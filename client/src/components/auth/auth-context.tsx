import { useState, useEffect, ReactNode } from "react";
import { AuthContext } from "./AuthContextInstance";
import { useNavigate } from "react-router-dom";
import { jwtDecode } from "jwt-decode";
import toast from "react-hot-toast";
import { setLogoutCallback } from "@/lib/auth-fetch";

export type UserRole = "student" | "faculty" | "hod" | "admin"| 'super-admin'| null;

export interface AuthContextType {
  isAuthenticated: boolean;
  role: UserRole;
  token: string | null;
  login: (token: string) => void;
  logout: (showExpiredMessage?: boolean) => void;
}


export const AuthProvider = ({ children }: { children: ReactNode }) => {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [role, setRole] = useState<UserRole>(null);
  const [token, setToken] = useState<string | null>(null);
  const navigate = useNavigate();

  // Check if token is expired
  const isTokenExpired = (token: string): boolean => {
    try {
  const decoded = jwtDecode<{ exp: number; role_name?: string }>(token);
      const currentTime = Date.now() / 1000;
      return decoded.exp < currentTime;
    } catch {
      return true;
    }
  };

  // Logout function
  const logout = (showExpiredMessage: boolean = false) => {
    setIsAuthenticated(false);
    setRole(null);
    setToken(null);
    localStorage.removeItem("jwt_token");
    if (showExpiredMessage) {
      toast.error("Session expired. Please login again.");
    }
  };

  useEffect(() => {
    const storedToken = localStorage.getItem("jwt_token");
    if (storedToken) {
      try {
        // Check if token is expired
        if (isTokenExpired(storedToken)) {
          logout(true);
          return;
        }
        const decoded = jwtDecode<{ exp: number; role_name?: string }>(storedToken);
        if (decoded && decoded.role_name) {
          setIsAuthenticated(true);
          setRole(decoded.role_name as UserRole);
          setToken(storedToken);
        } else {
          logout();
        }
      } catch {
        logout();
      }
    }
  }, []);

  // Set up interval to check token expiration every minute
  useEffect(() => {
    if (!token) return;
    const checkTokenExpiration = () => {
      if (token && isTokenExpired(token)) {
        logout(true);
      }
    };
    // Check immediately
    checkTokenExpiration();
    // Set up interval to check every minute
    const interval = setInterval(checkTokenExpiration, 60000);
    return () => clearInterval(interval);
  }, [token]);

  // Set up the logout callback for the auth-fetch utility
  useEffect(() => {
    setLogoutCallback(logout);
  }, []);

  const login = (jwtToken: string) => {
    try {
      // Check if token is expired before setting it
      if (isTokenExpired(jwtToken)) {
        logout();
        return;
      }
      const decoded = jwtDecode<{ exp: number; role_name?: string }>(jwtToken);
      if (decoded && decoded.role_name) {
        setIsAuthenticated(true);
        setRole(decoded.role_name as UserRole);
        setToken(jwtToken);
        localStorage.setItem("jwt_token", jwtToken);
        // Role-based redirection
        if (decoded.role_name === "student") navigate("/student");
        else if (decoded.role_name === "faculty") navigate("/faculty");
        else if (decoded.role_name === "hod") navigate("/hod");
        else if (decoded.role_name === "admin") navigate("/admin");
        else if (decoded.role_name === "super-admin") navigate("/super-admin");
        else navigate("/login");
      }
    } catch {
      logout();
    }
  };

  return (
    <AuthContext.Provider value={{ isAuthenticated, role, token, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

