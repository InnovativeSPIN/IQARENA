import React, { useEffect, useMemo, useState } from "react";
import { Card } from "../components/ui/card";
import { Button } from "../components/ui/button";
import icon from "../../public/icon.png"
const API_BASE = import.meta.env.VITE_API_BASE;


function parseCSV(text) {
  const lines = text.split(/\r?\n/).map((l) => l.trim()).filter(Boolean);
  if (!lines.length) return [];
  const headers = lines[0].split(",").map((h) => h.trim());
  return lines.slice(1).map((line) => {
    const cols = line.split(",").map((c) => c.trim());
    const obj = {};
    headers.forEach((h, i) => (obj[h] = cols[i] ?? ""));
    return obj;
  });
}

// Client-side CSV -> JSON exporter
function exportToCSV(filename, rows) {
  if (!rows || !rows.length) return;
  const headers = Object.keys(rows[0]);
  const csv = [headers.join(","), ...rows.map((r) => headers.map((h) => `"${(r[h] ?? "").toString().replace(/"/g, '""')}"`).join(","))].join("\n");
  const blob = new Blob([csv], { type: "text/csv" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = filename;
  a.click();
  URL.revokeObjectURL(url);
}

const Modal = ({ open, title, onClose, children }) => {
  if (!open) return null;
  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
      <div className="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4 lg:w-1/2 max-h-[90vh] overflow-auto">
        <div className="flex items-center justify-between px-6 py-4 border-b">
          <h3 className="text-lg font-semibold">{title}</h3>
          <Button variant="ghost" onClick={onClose}>Close</Button>
        </div>
        <div className="p-6">{children}</div>
      </div>
    </div>
  );
};

// Simple Table component (very lightweight)
const Table = ({ columns, rows, actions }) => {
  return (
    <div className="overflow-auto border rounded">
      <table className="w-full text-left table-auto">
        <thead className="bg-gray-50">
          <tr>
            {columns.map((c) => (
              <th key={c.key} className="px-4 py-3 text-sm font-medium text-gray-600">{c.title}</th>
            ))}
            {actions && <th className="px-4 py-3 text-sm font-medium text-gray-600">Actions</th>}
          </tr>
        </thead>
        <tbody>
          {rows.length === 0 && (
            <tr>
              <td colSpan={columns.length + (actions ? 1 : 0)} className="px-4 py-6 text-center text-gray-500">No records</td>
            </tr>
          )}
          {rows.map((r, idx) => (
            <tr key={idx} className="odd:bg-white even:bg-gray-50">
              {columns.map((c) => (
                <td key={c.key} className="px-4 py-3 text-sm text-gray-700 align-top">{c.render ? c.render(r) : r[c.key]}</td>
              ))}
              {actions && <td className="px-4 py-3">{actions(r)}</td>}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default function AdminDashboardPage() {
  // State management similar to SuperAdmin
  const [view, setView] = useState("dashboard");
  const [departments, setDepartments] = useState([]);
  const [faculty, setFaculty] = useState([]);
  const [students, setStudents] = useState([]);
  const [topics, setTopics] = useState([]);
  const [subTopics, setSubTopics] = useState([]);
  const [tests, setTests] = useState([]);
  
  // Filters
  const [facultyFilters, setFacultyFilters] = useState({ roll: '', name: '', department: '' });
  const [studentFilters, setStudentFilters] = useState({ roll: "", name: "", department: "", year: "" });
  const [topicFilter, setTopicFilter] = useState("");
  const [subTopicFilter, setSubTopicFilter] = useState("");
  
  // Modals
  const [addStaffModalOpen, setAddStaffModalOpen] = useState(false);
  const [addStudentModalOpen, setAddStudentModalOpen] = useState(false);
  const [studentEditModalOpen, setStudentEditModalOpen] = useState(false);
  const [studentsModalOpen, setStudentsModalOpen] = useState(false);
  const [subTopicModalOpen, setSubTopicModalOpen] = useState(false);
  const [questionModalOpen, setQuestionModalOpen] = useState(false);
  const [adminPwdModalOpen, setAdminPwdModalOpen] = useState(false);
  
  // Form state
  const [newStaff, setNewStaff] = useState({ roll_no: '', name: '', email: '', department_id: '' });
  const [newStudent, setNewStudent] = useState({ roll_no: '', name: '', email: '', department_id: '', year: '' });
  const [editingStudent, setEditingStudent] = useState<any>(null);
  const [editingQuestion, setEditingQuestion] = useState(null);
  const [adminPwdValue, setAdminPwdValue] = useState("");
  const [adminPwdLoading, setAdminPwdLoading] = useState(false);
  
  // CSV Upload state
  const [csvPreview, setCsvPreview] = useState([]);
  const [csvEditRows, setCsvEditRows] = useState([]);
  const [csvDept, setCsvDept] = useState("");
  const [csvYear, setCsvYear] = useState("");
  const [csvRole, setCsvRole] = useState("Student");
  const [csvFile, setCsvFile] = useState(null);
  
  // Topics state
  const [activeTopic, setActiveTopic] = useState(null);
  const [filteredSubTopics, setFilteredSubTopics] = useState([]);
  const [activeSubTopicQuestions, setActiveSubTopicQuestions] = useState([]);
  const [activeSubTopicTitle, setActiveSubTopicTitle] = useState("");
  const [subTopicsWithQuestions, setSubTopicsWithQuestions] = useState([]);
  
  // Loading states
  const [addStaffLoading, setAddStaffLoading] = useState(false);
  const [addStudentLoading, setAddStudentLoading] = useState(false);

  function handleLogout() {
    localStorage.removeItem("jwt_token");
    window.location.href = "/";
  }

  // Fetch departments
  useEffect(() => {
    fetch(`${API_BASE}/dept/departments`)
      .then(res => res.json())
      .then(data => {
        setDepartments(data.map(d => ({
          id: d.id,
          code: d.short_name,
          name: d.full_name,
          hodName: d.hod_name
        })));
      })
      .catch(() => setDepartments([]));
  }, []);

  // Fetch faculty
  useEffect(() => {
    fetch(`${API_BASE}/users/faculty-list`)
      .then(res => res.json())
      .then(data => {
        setFaculty(data.map(f => ({
          id: f.id,
          roll: f.roll_no,
          name: f.name,
          email: f.email,
          department: f.department_name
        })));
      })
      .catch(() => setFaculty([]));
  }, []);

  // Fetch students
  useEffect(() => {
    fetch(`${API_BASE}/users/list`)
      .then(res => res.json())
      .then(data => {
        setStudents(data.map(s => ({
          id: s.id,
          roll: s.roll_no,
          name: s.name,
          email: s.email,
          department: s.department_name,
          year: s.year
        })));
      })
      .catch(() => setStudents([]));
  }, []);

  // Fetch topics
  useEffect(() => {
    fetch(`${API_BASE}/question/topics`)
      .then(res => res.json())
      .then(data => setTopics(data.topics || []))
      .catch(() => setTopics([]));
    
    fetch(`${API_BASE}/question/sub-topics`)
      .then(res => res.json())
      .then(data => setSubTopics(data.sub_topics || []))
      .catch(() => setSubTopics([]));
      
    fetch(`${API_BASE}/question/sub-topics-with-questions`)
      .then(res => res.json())
      .then(data => setSubTopicsWithQuestions(data.sub_topics || []))
      .catch(() => setSubTopicsWithQuestions([]));
  }, []);

  // Filtered data
  const filteredFaculty = useMemo(() => {
    return faculty.filter(f =>
      (!facultyFilters.roll || f.roll?.toLowerCase().includes(facultyFilters.roll.toLowerCase())) &&
      (!facultyFilters.name || f.name?.toLowerCase().includes(facultyFilters.name.toLowerCase())) &&
      (!facultyFilters.department || f.department === facultyFilters.department)
    );
  }, [faculty, facultyFilters]);

  const filteredStudents = useMemo(() => {
    return students.filter(s =>
      (!studentFilters.roll || s.roll?.toLowerCase().includes(studentFilters.roll.toLowerCase())) &&
      (!studentFilters.name || s.name?.toLowerCase().includes(studentFilters.name.toLowerCase())) &&
      (!studentFilters.department || s.department === studentFilters.department) &&
      (!studentFilters.year || String(s.year) === String(studentFilters.year))
    );
  }, [students, studentFilters]);

  const stats = useMemo(() => ({
    departments: departments.length,
    faculty: faculty.length,
    students: students.length,
    topics: topics.length,
  }), [departments, faculty, students, topics]);

  // Handler functions
  async function handleAddStaff() {
    setAddStaffLoading(true);
    try {
      const payload = {
        roll_no: newStaff.roll_no,
        name: newStaff.name,
        email: newStaff.email,
        department_id: newStaff.department_id
      };
      const res = await fetch(`${API_BASE}/users/add-staff`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      const result = await res.json();
      if (res.ok && result.success) {
        setFaculty(f => [
          {
            id: result.insertedId,
            name: newStaff.name,
            roll: newStaff.roll_no,
            email: newStaff.email,
            department: departments.find(d => d.id == newStaff.department_id)?.code || ''
          },
          ...f
        ]);
        setAddStaffModalOpen(false);
        setNewStaff({ roll_no: '', name: '', email: '', department_id: '' });
        alert('Staff added successfully.');
      } else {
        alert(result.error || 'Failed to add staff.');
      }
    } catch (err) {
      alert('Error adding staff: ' + (err?.message || 'Unknown error'));
    }
    setAddStaffLoading(false);
  }

  async function handleAddStudent() {
    setAddStudentLoading(true);
    try {
      const res = await fetch(`${API_BASE}/users/add`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(newStudent)
      });
      const result = await res.json();
      if (res.ok && result.success) {
        const deptObj = departments.find(d => d.id == newStudent.department_id);
        setStudents(s => [
          {
            id: result.insertedId,
            roll: newStudent.roll_no,
            name: newStudent.name,
            email: newStudent.email,
            department: deptObj ? deptObj.code : '',
            year: newStudent.year
          },
          ...s
        ]);
        setAddStudentModalOpen(false);
        setNewStudent({ roll_no: '', name: '', email: '', department_id: '', year: '' });
        alert('Student added successfully.');
      } else {
        alert(result.error || 'Failed to add student.');
      }
    } catch (err) {
      alert('Error adding student: ' + (err?.message || 'Unknown error'));
    }
    setAddStudentLoading(false);
  }

  async function resetFacultyPassword(id) {
    const password = prompt('Enter new password for this staff:');
    if (!password) return;
    try {
      const res = await fetch(`${API_BASE}/users/reset-password-faculty/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ password })
      });
      const result = await res.json();
      if (result.success) {
        alert('Password reset successfully.');
      } else {
        alert(result.error || 'Failed to reset password.');
      }
    } catch (err) {
      alert('Error resetting password: ' + (err?.message || 'Unknown error'));
    }
  }

  async function deleteFaculty(id) {
    if (!confirm("Remove faculty profile?")) return;
    try {
      const res = await fetch(`${API_BASE}/users/delete-faculty/${id}`, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' }
      });
      const result = await res.json();
      if (result.success) {
        setFaculty((f) => f.filter((x) => x.id !== id));
        alert('Faculty deleted successfully.');
      } else {
        alert(result.error || 'Failed to delete faculty.');
      }
    } catch (err) {
      alert('Error deleting faculty: ' + (err?.message || 'Unknown error'));
    }
  }

  async function removeStudent(id) {
    if (!confirm("Remove student?")) return;
    try {
      const res = await fetch(`${API_BASE}/users/delete/${id}`, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' }
      });
      const result = await res.json();
      if (res.ok && result.success) {
        setStudents((s) => s.filter((x) => x.id !== id));
        alert('Student deleted successfully.');
      } else {
        alert(result.error || 'Failed to delete student.');
      }
    } catch (err) {
      alert('Error deleting student: ' + (err?.message || 'Unknown error'));
    }
  }

  async function resetStudentPassword(id) {
    if (!confirm("Reset password for this student?")) return;
    try {
      const res = await fetch(`${API_BASE}/users/reset-password/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
      });
      const result = await res.json();
      if (result.success) {
        alert('Password reset successfully.');
      } else {
        alert(result.error || 'Failed to reset password.');
      }
    } catch (err) {
      alert('Error resetting password: ' + err.message);
    }
  }

  function openStudentEditModal(r: any): void {
    setEditingStudent(r);
    setStudentEditModalOpen(true);
  }

  function handleStudentCSVUpload(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      const text = e.target.result;
      const parsed = parseCSV(text);
      setCsvPreview(parsed);
      setCsvEditRows(parsed.map((row) => ({ ...row })));
      setCsvDept("");
      setCsvYear("");
      setCsvRole("Student");
      setStudentsModalOpen(true);
    };
    reader.readAsText(file);
  }

  async function commitCsvStudents() {
    if (!csvEditRows.length) return alert("No CSV data to import");
    if (!csvDept) return alert("Please select department");
    if (!csvYear) return alert("Please select year");
    
    const newStudents = csvEditRows.map((r, idx) => ({
      roll: r.roll || r.roll_no || r.roll_number || r.Roll || `R${Date.now() + idx}`,
      name: r.name || r.fullname || r.Name || "Unknown",
      email: r.email || r.Email || "",
      department: csvDept,
      year: parseInt(csvYear, 10),
      role: 1
    }));
    
    try {
      const res = await fetch(`${API_BASE}/users/upload`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ students: newStudents })
      });
      const result = await res.json();
      if (result.success) {
        const studentsWithId = newStudents.map((stu, idx) => ({
          ...stu,
          id: Date.now() + idx
        }));
        setStudents((s) => [...studentsWithId, ...s]);
        setCsvPreview([]);
        setCsvEditRows([]);
        setStudentsModalOpen(false);
        setCsvDept("");
        setCsvYear("");
        alert(`Imported ${newStudents.length} students successfully.`);
      } else {
        alert(`Import failed: ${result.error || 'Unknown error'}`);
      }
    } catch (err) {
      alert(`Import failed: ${err.message}`);
    }
  }

  async function handleAdminResetPassword() {
    if (!adminPwdValue) return alert("Please enter a password.");
    setAdminPwdLoading(true);
    try {
      const token = localStorage.getItem('jwt_token');
      const res = await fetch(`${API_BASE}/users/reset-password-admin`, {
        method: 'POST',
        headers: { 
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify({ password: adminPwdValue })
      });
      const result = await res.json();
      if (result.success) {
        alert('Password reset successfully.');
        setAdminPwdModalOpen(false);
        setAdminPwdValue("");
      } else {
        alert(result.error || 'Failed to reset password.');
      }
    } catch (err) {
      alert('Error resetting password: ' + (err?.message || 'Unknown error'));
    }
    setAdminPwdLoading(false);
  }

  return (
    <div className="flex min-h-screen bg-gray-50 text-slate-800">
      {/* Sidebar */}
      <aside className="w-64 bg-white border-r shadow-sm hidden md:block">
        <nav className="flex flex-col h-full p-6 gap-3">
          <div className="font-extrabold flex flex-col items-center text-2xl mb-4 text-orange-600">
            <img src={icon} alt="" width={50} />
            <h2>IQARENA</h2>
          </div>
          <SidebarLink active={view === "dashboard"} onClick={() => setView("dashboard")}>
            <span className="inline-block mr-2 align-middle">🏠</span>Dashboard
          </SidebarLink>
          <SidebarLink active={view === "departments"} onClick={() => setView("departments")}>
            <span className="inline-block mr-2 align-middle">🏢</span>Departments
          </SidebarLink>
          <SidebarLink active={view === "staff"} onClick={() => setView("staff")}>
            <span className="inline-block mr-2 align-middle">👨‍🏫</span>Staff
          </SidebarLink>
          <SidebarLink active={view === "students"} onClick={() => setView("students")}>
            <span className="inline-block mr-2 align-middle">🎓</span>Students
          </SidebarLink>
          <SidebarLink active={view === "topics"} onClick={() => setView("topics")}>
            <span className="inline-block mr-2 align-middle">📚</span>Topics
          </SidebarLink>
          <SidebarLink active={view === "reports"} onClick={() => setView("reports")}>
            <span className="inline-block mr-2 align-middle">📊</span>Reports
          </SidebarLink>
        </nav>
      </aside>

      {/* Main */}
      <div className="flex-1 flex flex-col">
        {/* Topbar */}
        <header className="flex items-center justify-end px-6 py-4 bg-white border-b">
          <div className="flex items-center gap-4">
            <div className="text-sm text-slate-600">Admin</div>
            <Button
              variant="outline"
              size="sm"
              className="flex items-center gap-2"
              title="Reset Password"
              onClick={() => setAdminPwdModalOpen(true)}
            >
              <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 17a2 2 0 100-4 2 2 0 000 4zm6-7V7a6 6 0 10-12 0v3a2 2 0 00-2 2v7a2 2 0 002 2h12a2 2 0 002-2v-7a2 2 0 00-2-2zm-8-3a4 4 0 118 0v3" /></svg>
            </Button>
            <Button variant="outline" size="sm" className="flex items-center gap-2" onClick={handleLogout} title="Logout">
              <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" /></svg>
            </Button>
          </div>
        </header>

        <main className="p-6 flex-1 overflow-auto">
          {/* Dashboard View */}
          {view === "dashboard" && (
            <div className="space-y-6">
              <h2 className="text-2xl font-bold">Admin Dashboard</h2>
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <Card className="p-4 text-center">
                  <div className="text-2xl font-bold text-orange-600">{stats.departments}</div>
                  <div className="text-sm text-slate-500">Departments</div>
                </Card>
                <Card className="p-4 text-center">
                  <div className="text-2xl font-bold text-orange-600">{stats.faculty}</div>
                  <div className="text-sm text-slate-500">Faculty</div>
                </Card>
                <Card className="p-4 text-center">
                  <div className="text-2xl font-bold text-orange-600">{stats.students}</div>
                  <div className="text-sm text-slate-500">Students</div>
                </Card>
                <Card className="p-4 text-center">
                  <div className="text-2xl font-bold text-orange-600">{stats.topics}</div>
                  <div className="text-sm text-slate-500">Topics</div>
                </Card>
              </div>
            </div>
          )}

          {/* Departments View */}
          {view === "departments" && (
            <div className="space-y-6">
              <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold">Departments</h2>
              </div>
              <Card className="mb-2 p-3 bg-orange-50 border-orange-200">
                <span className="font-semibold text-orange-700">
                  Total Staff: {faculty.length} &nbsp;|&nbsp; Total Students: {students.length}
                </span>
              </Card>
              <Card>
                <Table
                  columns={[
                    { key: "code", title: "Code" },
                    { key: "name", title: "Name" },
                    { key: "hodName", title: "HOD" },
                    { key: "facultyCount", title: "Faculty" },
                    { key: "studentCount", title: "Students" }
                  ]}
                  rows={departments.map(dept => ({
                    ...dept,
                    facultyCount: faculty.filter(f => f.department === dept.code || f.department === dept.name).length,
                    studentCount: students.filter(s => s.department === dept.code || s.department === dept.name).length
                  }))}
                  actions={() => null}
                />
              </Card>
            </div>
          )}

          {/* Staff View */}
          {view === "staff" && (
            <div className="space-y-6">
              <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold">Faculty / Staff</h2>
                <Button onClick={() => setAddStaffModalOpen(true)}>Add Staff</Button>
              </div>
              <Card className="mb-2 p-3 bg-orange-50 border-orange-200">
                <span className="font-semibold text-orange-700">
                  {facultyFilters.department
                    ? `Total Staff in ${facultyFilters.department}: ${filteredFaculty.length}`
                    : `Total Staff: ${filteredFaculty.length}`}
                </span>
              </Card>
              <Card className="mb-4 p-4">
                <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                  <input
                    type="text"
                    placeholder="Filter by Roll No"
                    className="border px-3 py-2 rounded"
                    value={facultyFilters.roll}
                    onChange={e => setFacultyFilters(f => ({ ...f, roll: e.target.value }))}
                  />
                  <input
                    type="text"
                    placeholder="Filter by Name"
                    className="border px-3 py-2 rounded"
                    value={facultyFilters.name}
                    onChange={e => setFacultyFilters(f => ({ ...f, name: e.target.value }))}
                  />
                  <select
                    className="border px-3 py-2 rounded"
                    value={facultyFilters.department}
                    onChange={e => setFacultyFilters(f => ({ ...f, department: e.target.value }))}
                  >
                    <option value="">All Departments</option>
                    {departments.map(d => <option key={d.id} value={d.code}>{d.name}</option>)}
                  </select>
                </div>
              </Card>
              <Card>
                <Table
                  columns={[
                    { key: "roll", title: "Roll No" },
                    { key: "name", title: "Name" },
                    { key: "email", title: "Email" },
                    { key: "department", title: "Department" }
                  ]}
                  rows={filteredFaculty}
                  actions={(r) => (
                    <div className="flex gap-2">
                      <Button size="sm" variant="ghost" title="Reset Password" onClick={() => resetFacultyPassword(r.id)}>
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 17a2 2 0 100-4 2 2 0 000 4zm6-7V7a6 6 0 10-12 0v3a2 2 0 00-2 2v7a2 2 0 002 2h12a2 2 0 002-2v-7a2 2 0 00-2-2zm-8-3a4 4 0 118 0v3" /></svg>
                      </Button>
                      <Button size="sm" variant="ghost" title="Remove" onClick={() => deleteFaculty(r.id)}>
                        <span role="img" aria-label="remove">❌</span>
                      </Button>
                    </div>
                  )}
                />
              </Card>
            </div>
          )}

          {/* Students View */}
          {view === "students" && (
            <div className="space-y-6">
              <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold">Students</h2>
                <div className="flex gap-2">
                  <Button onClick={() => setAddStudentModalOpen(true)} className="bg-orange-600 text-white">Add Student</Button>
                  <label htmlFor="studentsCSV" className="cursor-pointer"><Button onClick={() => setStudentsModalOpen(true)}>Upload CSV</Button></label>
                </div>
              </div>
              <Card className="mb-2 p-3 bg-orange-50 border-orange-200">
                <span className="font-semibold text-orange-700">
                  {studentFilters.department && studentFilters.year
                    ? `Total Students in ${studentFilters.department}, Year ${studentFilters.year}: ${filteredStudents.length}`
                    : studentFilters.department
                      ? `Total Students in ${studentFilters.department}: ${filteredStudents.length}`
                      : studentFilters.year
                        ? `Total Students in Year ${studentFilters.year}: ${filteredStudents.length}`
                        : `Total Students: ${filteredStudents.length}`}
                </span>
              </Card>
              <Card className="mb-4 p-4">
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                  <input
                    type="text"
                    placeholder="Filter by Roll No"
                    className="border px-3 py-2 rounded"
                    value={studentFilters.roll}
                    onChange={e => setStudentFilters(f => ({ ...f, roll: e.target.value }))}
                  />
                  <input
                    type="text"
                    placeholder="Filter by Name"
                    className="border px-3 py-2 rounded"
                    value={studentFilters.name}
                    onChange={e => setStudentFilters(f => ({ ...f, name: e.target.value }))}
                  />
                  <select
                    className="border px-3 py-2 rounded"
                    value={studentFilters.department}
                    onChange={e => setStudentFilters(f => ({ ...f, department: e.target.value }))}
                  >
                    <option value="">All Departments</option>
                    {departments.map(d => <option key={d.id} value={d.code}>{d.name}</option>)}
                  </select>
                  <input
                    type="number"
                    placeholder="Year"
                    className="border px-3 py-2 rounded"
                    value={studentFilters.year}
                    onChange={e => setStudentFilters(f => ({ ...f, year: e.target.value }))}
                  />
                </div>
              </Card>
              <input
                id="studentsCSV"
                type="file"
                accept=".csv"
                className="hidden"
                onChange={(e) => e.target.files?.[0] && handleStudentCSVUpload(e.target.files[0])}
              />
              <Card>
                <Table
                  columns={[
                    { key: "roll", title: "Roll No" },
                    { key: "name", title: "Name" },
                    { key: "email", title: "Email" },
                    { key: "department", title: "Department" },
                    { key: "year", title: "Year" }
                  ]}
                  rows={filteredStudents}
                  actions={(r) => (
                    <div className="flex gap-2">
                      <Button size="sm" variant="ghost" title="Edit" onClick={() => openStudentEditModal(r)}>
                        <span role="img" aria-label="edit">✏️</span>
                      </Button>
                      <Button size="sm" variant="ghost" title="Reset Password" onClick={() => resetStudentPassword(r.id)}>
                        <span role="img" aria-label="reset">🔑</span>
                      </Button>
                      <Button size="sm" variant="ghost" title="Remove" onClick={() => removeStudent(r.id)}>
                        <span role="img" aria-label="remove">❌</span>
                      </Button>
                    </div>
                  )}
                />
              </Card>
            </div>
          )}

          {/* Topics View */}
          {view === "topics" && (
            <div className="space-y-6">
              <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold">Topics</h2>
              </div>
              <Card>
                <input
                  type="text"
                  className="border px-3 py-2 rounded w-full mb-4"
                  placeholder="Filter topics by title or description"
                  value={topicFilter}
                  onChange={e => setTopicFilter(e.target.value)}
                />
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                  {topics.filter(topic =>
                    topic.title.toLowerCase().includes(topicFilter.toLowerCase()) ||
                    topic.description.toLowerCase().includes(topicFilter.toLowerCase())
                  ).length === 0 && <div className="p-4 text-gray-500">No topics found.</div>}
                  {topics.filter(topic =>
                    topic.title.toLowerCase().includes(topicFilter.toLowerCase()) ||
                    topic.description.toLowerCase().includes(topicFilter.toLowerCase())
                  ).map(topic => (
                    <div key={topic.topic_id} className="p-4 border rounded shadow-sm cursor-pointer hover:bg-orange-50" onClick={() => {
                      setActiveTopic(topic);
                      setFilteredSubTopics(subTopics.filter(st => st.topic_id === topic.topic_id));
                      setSubTopicModalOpen(true);
                    }}>
                      <div className="font-semibold text-lg">{topic.title}</div>
                      <div className="text-sm text-gray-600 mb-2">{topic.description}</div>
                      <div className="text-xs text-gray-500">Added by: {topic.user_name || 'Unknown'}</div>
                      <div className="text-xs text-gray-400">Created: {new Date(topic.created_at).toLocaleString()}</div>
                    </div>
                  ))}
                </div>
              </Card>
            </div>
          )}

          {/* Reports View */}
          {view === "reports" && (
            <div className="space-y-6">
              <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold">Reports & Analytics</h2>
                <Button onClick={() => exportToCSV("students_report.csv", students)}>Export Student CSV</Button>
              </div>
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <Card className="p-4 text-center">
                  <div className="text-2xl font-bold text-orange-600">{stats.departments}</div>
                  <div className="text-sm text-slate-500">Departments</div>
                </Card>
                <Card className="p-4 text-center">
                  <div className="text-2xl font-bold text-orange-600">{stats.faculty}</div>
                  <div className="text-sm text-slate-500">Faculty</div>
                </Card>
                <Card className="p-4 text-center">
                  <div className="text-2xl font-bold text-orange-600">{stats.students}</div>
                  <div className="text-sm text-slate-500">Students</div>
                </Card>
                <Card className="p-4 text-center">
                  <div className="text-2xl font-bold text-orange-600">{stats.topics}</div>
                  <div className="text-sm text-slate-500">Topics</div>
                </Card>
              </div>
            </div>
          )}
        </main>
      </div>

      {/* Modals */}
      <Modal open={adminPwdModalOpen} title="Reset Admin Password" onClose={() => setAdminPwdModalOpen(false)}>
        <div className="space-y-3">
          <label className="text-sm">Enter New Password</label>
          <input
            type="password"
            value={adminPwdValue}
            onChange={e => setAdminPwdValue(e.target.value)}
            className="border px-3 py-2 rounded w-full"
            placeholder="New password"
            disabled={adminPwdLoading}
          />
          <div className="flex gap-2 mt-4">
            <Button onClick={handleAdminResetPassword} disabled={adminPwdLoading}>Reset</Button>
            <Button variant="outline" onClick={() => setAdminPwdModalOpen(false)} disabled={adminPwdLoading}>Cancel</Button>
          </div>
        </div>
      </Modal>

      <Modal open={addStaffModalOpen} title="Add Staff" onClose={() => setAddStaffModalOpen(false)}>
        <div className="space-y-3">
          <label className="text-sm">Roll No</label>
          <input value={newStaff.roll_no} onChange={e => setNewStaff(s => ({ ...s, roll_no: e.target.value }))} className="border px-3 py-2 rounded w-full" />
          <label className="text-sm">Name</label>
          <input value={newStaff.name} onChange={e => setNewStaff(s => ({ ...s, name: e.target.value }))} className="border px-3 py-2 rounded w-full" />
          <label className="text-sm">Email</label>
          <input value={newStaff.email} onChange={e => setNewStaff(s => ({ ...s, email: e.target.value }))} className="border px-3 py-2 rounded w-full" />
          <label className="text-sm">Department</label>
          <select value={newStaff.department_id} onChange={e => setNewStaff(s => ({ ...s, department_id: e.target.value }))} className="border px-3 py-2 rounded w-full">
            <option value="">-- select --</option>
            {departments.map(d => <option key={d.id} value={d.id}>{d.code} - {d.name}</option>)}
          </select>
          <div className="flex gap-2 mt-4">
            <Button onClick={handleAddStaff} disabled={addStaffLoading}>Add</Button>
            <Button variant="outline" onClick={() => setAddStaffModalOpen(false)} disabled={addStaffLoading}>Cancel</Button>
          </div>
        </div>
      </Modal>

      <Modal open={addStudentModalOpen} title="Add Student" onClose={() => setAddStudentModalOpen(false)}>
        <div className="space-y-3">
          <label className="text-sm">Roll No</label>
          <input value={newStudent.roll_no} onChange={e => setNewStudent(s => ({ ...s, roll_no: e.target.value }))} className="border px-3 py-2 rounded w-full" />
          <label className="text-sm">Name</label>
          <input value={newStudent.name} onChange={e => setNewStudent(s => ({ ...s, name: e.target.value }))} className="border px-3 py-2 rounded w-full" />
          <label className="text-sm">Email</label>
          <input value={newStudent.email} onChange={e => setNewStudent(s => ({ ...s, email: e.target.value }))} className="border px-3 py-2 rounded w-full" />
          <label className="text-sm">Department</label>
          <select value={newStudent.department_id} onChange={e => setNewStudent(s => ({ ...s, department_id: e.target.value }))} className="border px-3 py-2 rounded w-full">
            <option value="">-- select --</option>
            {departments.map(d => <option key={d.id} value={d.id}>{d.code} - {d.name}</option>)}
          </select>
          <label className="text-sm">Year</label>
          <input type="number" value={newStudent.year} onChange={e => setNewStudent(s => ({ ...s, year: e.target.value }))} className="border px-3 py-2 rounded w-full" />
          <div className="flex gap-2 mt-4">
            <Button onClick={handleAddStudent} disabled={addStudentLoading}>Add</Button>
            <Button variant="outline" onClick={() => setAddStudentModalOpen(false)} disabled={addStudentLoading}>Cancel</Button>
          </div>
        </div>
      </Modal>

      {/* CSV Upload Modal - Similar to SuperAdmin */}
      <Modal open={studentsModalOpen} title="Import Students CSV" onClose={() => setStudentsModalOpen(false)}>
        <div className="space-y-4">
          <div>
            <label className="block mb-1 text-sm font-medium">Upload CSV File</label>
            <input
              type="file"
              accept=".csv"
              className="border px-3 py-2 rounded w-full"
              onChange={e => {
                if (e.target.files?.[0]) {
                  setCsvFile(e.target.files[0]);
                  handleStudentCSVUpload(e.target.files[0]);
                }
              }}
            />
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label className="block mb-1 text-sm font-medium">Select Department</label>
              <select className="border px-3 py-2 rounded w-full" value={csvDept} onChange={e => setCsvDept(e.target.value)}>
                <option value="">-- select department --</option>
                {departments.map(d => (
                  <option key={d.id} value={d.id}>
                    {d.code} - {d.name}
                  </option>
                ))}
              </select>
            </div>
            <div>
              <label className="block mb-1 text-sm font-medium">Select Year</label>
              <select className="border px-3 py-2 rounded w-full" value={csvYear} onChange={e => setCsvYear(e.target.value)}>
                <option value="">-- select year --</option>
                {[1,2,3,4].map(y => <option key={y} value={y}>{y}</option>)}
              </select>
            </div>
          </div>
          <div className="flex gap-2 mt-2">
            <Button onClick={commitCsvStudents}>Import Students</Button>
            <Button variant="outline" onClick={() => setStudentsModalOpen(false)}>Cancel</Button>
          </div>
        </div>
      </Modal>

      {/* Student Edit Modal */}
      <Modal open={studentEditModalOpen} title="Edit Student" onClose={() => setStudentEditModalOpen(false)}>
        {editingStudent && (
          <StudentEditForm
            initial={editingStudent}
            departments={departments}
            onCancel={() => setStudentEditModalOpen(false)}
            onSave={async (data) => {
              const payload = {
                roll_no: data.roll,
                name: data.name,
                email: data.email,
                department_id: departments.find(d => d.code === data.department)?.id || data.department,
                year: data.year
              };
              const res = await fetch(`${API_BASE}/users/update/${editingStudent.id}`, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload)
              });
              if (res.ok) {
                setStudents((ss) => ss.map((s) => s.id === editingStudent.id ? { ...s, ...data } : s));
                setStudentEditModalOpen(false);
              } else {
                alert("Failed to update student info");
              }
            }}
          />
        )}
      </Modal>

      {/* Sub-topic Modal */}
      <Modal open={subTopicModalOpen} title={activeTopic ? `Sub Topics for ${activeTopic.title}` : "Sub Topics"} onClose={() => setSubTopicModalOpen(false)}>
        <div className="space-y-3">
          <input
            type="text"
            className="border px-3 py-2 rounded w-full mb-2"
            placeholder="Filter sub-topics"
            value={subTopicFilter}
            onChange={e => setSubTopicFilter(e.target.value)}
          />
          {filteredSubTopics.filter(sub =>
            sub.title.toLowerCase().includes(subTopicFilter.toLowerCase()) ||
            sub.description.toLowerCase().includes(subTopicFilter.toLowerCase())
          ).length === 0 && <div className="text-gray-500">No sub-topics for this topic.</div>}
          {filteredSubTopics.filter(sub =>
            sub.title.toLowerCase().includes(subTopicFilter.toLowerCase()) ||
            sub.description.toLowerCase().includes(subTopicFilter.toLowerCase())
          ).map(sub => (
            <div key={sub.sub_topic_id} className="p-3 border rounded mb-2 cursor-pointer hover:bg-orange-50" onClick={() => {
              const subWithQ = subTopicsWithQuestions.find(st => st.sub_topic_id === sub.sub_topic_id);
              setActiveSubTopicQuestions(subWithQ?.questions || []);
              setActiveSubTopicTitle(sub.title);
              setQuestionModalOpen(true);
            }}>
              <div className="font-semibold">{sub.title}</div>
              <div className="text-sm text-gray-600 mb-1">{sub.description}</div>
              <div className="text-xs text-gray-500">Added by: {sub.user_name || 'Unknown'}</div>
              <div className="text-xs text-gray-400">Created: {new Date(sub.created_at).toLocaleString()}</div>
            </div>
          ))}
        </div>
      </Modal>

      {/* Questions Modal */}
      <Modal open={questionModalOpen} title={`Questions for ${activeSubTopicTitle}`} onClose={() => setQuestionModalOpen(false)}>
        <div className="space-y-3">
          {activeSubTopicQuestions.length === 0 && <div className="text-gray-500">No questions for this sub-topic.</div>}
          {activeSubTopicQuestions.map(q => (
            <div key={q.question_id} className="p-3 border rounded mb-2">
              <div className="font-semibold">{q.text}</div>
              <div className="text-xs text-gray-500">A: {q.a} | B: {q.b} | C: {q.c} | D: {q.d}</div>
              <div className="text-xs text-green-600">Correct: {q.correct}</div>
            </div>
          ))}
        </div>
      </Modal>
    </div>
  );
}

/* Helper Components */
function SidebarLink({ children, active, onClick }) {
  return (
    <button onClick={onClick} className={`text-left py-2 px-3 rounded ${active ? "bg-orange-50 font-semibold text-orange-600" : "hover:bg-orange-50"}`}>
      {children}
    </button>
  );
}

function StudentEditForm({ initial, onSave, onCancel, departments }) {
  const [data, setData] = useState(initial || { roll: "", name: "", email: "", department: "", year: "" });
  const [loading, setLoading] = useState(false);
  useEffect(() => setData(initial || { roll: "", name: "", email: "", department: "", year: "" }), [initial]);
  return (
    <div>
      <label className="text-sm">Roll No</label>
      <input value={data.roll} onChange={e => setData(d => ({ ...d, roll: e.target.value }))} className="border px-3 py-2 rounded w-full mb-2" />
      <label className="text-sm">Name</label>
      <input value={data.name} onChange={e => setData(d => ({ ...d, name: e.target.value }))} className="border px-3 py-2 rounded w-full mb-2" />
      <label className="text-sm">Email</label>
      <input value={data.email} onChange={e => setData(d => ({ ...d, email: e.target.value }))} className="border px-3 py-2 rounded w-full mb-2" />
      <label className="text-sm">Department</label>
      <select value={data.department} onChange={e => setData(d => ({ ...d, department: e.target.value }))} className="border px-3 py-2 rounded w-full mb-2">
        <option value="">-- select --</option>
        {departments.map((d) => <option key={d.id} value={d.code}>{d.name}</option>)}
      </select>
      <label className="text-sm">Year</label>
      <input type="number" value={data.year} onChange={e => setData(d => ({ ...d, year: e.target.value }))} className="border px-3 py-2 rounded w-full mb-2" />
      <div className="flex gap-2 mt-4">
        <Button disabled={loading} onClick={async () => {
          setLoading(true);
          await onSave(data);
          setLoading(false);
        }}>Save</Button>
        <Button variant="outline" onClick={onCancel} disabled={loading}>Cancel</Button>
      </div>
    </div>
  );
}
