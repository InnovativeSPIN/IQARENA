-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 12, 2025 at 07:33 AM
-- Server version: 8.0.37
-- PHP Version: 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nscet_iqarena`
--

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

CREATE TABLE `analytics` (
  `analytics_id` int NOT NULL,
  `student_id` int NOT NULL,
  `test_id` int NOT NULL,
  `total_questions` int NOT NULL,
  `attempted` int NOT NULL,
  `correct_answers` int NOT NULL,
  `wrong_answers` int NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `short_name`, `full_name`) VALUES
(1, 'cse', 'B.E. Computer Science & Engineering'),
(2, 'civil', 'B.E. Civil Engineering'),
(3, 'ece', 'B.E. Electronics & Communication Engineering'),
(4, 'eee', 'B.E. Electrical and Electronics Engineering'),
(5, 'mech', 'B.E. Mechanical Engineering'),
(6, 'ai-and-ds', 'B.Tech. Artificial Intelligence & Data Science'),
(7, 'it', 'B.Tech. Information Technology'),
(8, 'se', 'Structural Engineering'),
(9, 'mfe', 'Manufacturing Engineering'),
(10, 's-and-h', 'Science and Humanities');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int NOT NULL,
  `student_test_id` int DEFAULT NULL,
  `faculty_id` int DEFAULT NULL,
  `comments` text,
  `given_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `leaderboard_id` int NOT NULL,
  `student_id` int NOT NULL,
  `total_tests` int DEFAULT '0',
  `total_score` decimal(10,2) DEFAULT '0.00',
  `average_score` decimal(5,2) DEFAULT '0.00',
  `highest_score` decimal(5,2) DEFAULT '0.00',
  `rank_position` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `reset_id` int NOT NULL,
  `user_id` int NOT NULL,
  `otp` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int NOT NULL,
  `sub_topic_id` int NOT NULL,
  `created_by` int NOT NULL,
  `by_admin` tinyint(1) DEFAULT '0',
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` enum('A','B','C','D') NOT NULL,
  `mark` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `sub_topic_id`, `created_by`, `by_admin`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `mark`, `created_at`) VALUES
(1, 6, 14, 0, 'Who developed Python Programming Language?', 'Wick van Rossum', 'Rasmus Lerdorf', 'Guido van Rossum', 'Niene Stom', 'C', 1, '2025-09-05 16:02:53'),
(2, 6, 14, 0, 'Which type of Programming does Python support?', 'object-oriented programming', 'structured programming', 'functional programming', 'all of the mentioned', 'D', 1, '2025-09-05 16:02:54'),
(3, 6, 14, 0, 'Is Python case sensitive when dealing with identifiers?', 'no', 'yes', 'machine dependent', 'none of the mentioned', 'B', 1, '2025-09-05 16:02:54'),
(4, 6, 14, 0, 'Which of the following is the correct extension of the Python file?', '.python', '.pl', '.py', '.p', 'C', 1, '2025-09-05 16:02:56'),
(5, 6, 14, 0, 'Is Python code compiled or interpreted?', 'Python code is both compiled and interpreted', 'Python code is neither compiled nor interpreted', 'Python code is only compiled', 'Python code is only interpreted', 'A', 1, '2025-09-05 16:02:56'),
(6, 6, 14, 0, 'All keywords in Python are in _________', 'Capitalized', 'lower case', 'UPPER CASE', 'None of the mentioned', 'D', 1, '2025-09-05 16:02:56'),
(7, 6, 14, 0, 'What will be the value of the following Python expression? print(4 + 3 % 5)', '7', '2', '4', '1', 'A', 1, '2025-09-05 16:02:56'),
(8, 6, 14, 0, 'Which of the following is used to define a block of code in Python language?', 'Indentation', 'Key', 'Brackets', 'All of the mentioned', 'A', 1, '2025-09-05 16:02:56'),
(9, 6, 14, 0, 'Which keyword is used for function in Python language?', 'Function', 'def', 'Fun', 'Define', 'B', 1, '2025-09-05 16:02:56'),
(10, 6, 14, 0, 'Which of the following character is used to give single-line comments in Python?', '//', '#', '!', '/*', 'B', 1, '2025-09-05 16:02:56'),
(11, 6, 14, 0, 'Who developed Python Programming Language?', 'Wick van Rossum', 'Rasmus Lerdorf', 'Guido van Rossum', 'Niene Stom', 'C', 1, '2025-09-05 16:25:45'),
(12, 6, 14, 0, 'Which type of Programming does Python support?', 'object-oriented programming', 'structured programming', 'functional programming', 'all of the mentioned', 'D', 1, '2025-09-05 16:25:45'),
(13, 6, 14, 0, 'Is Python case sensitive when dealing with identifiers?', 'no', 'yes', 'machine dependent', 'none of the mentioned', 'B', 1, '2025-09-05 16:25:45'),
(14, 6, 14, 0, 'Which of the following is the correct extension of the Python file?', '.python', '.pl', '.py', '.p', 'C', 1, '2025-09-05 16:25:45'),
(15, 6, 14, 0, 'Is Python code compiled or interpreted?', 'Python code is both compiled and interpreted', 'Python code is neither compiled nor interpreted', 'Python code is only compiled', 'Python code is only interpreted', 'A', 1, '2025-09-05 16:25:45'),
(16, 6, 14, 0, 'All keywords in Python are in _________', 'Capitalized', 'lower case', 'UPPER CASE', 'None of the mentioned', 'D', 1, '2025-09-05 16:25:45'),
(17, 6, 14, 0, 'What will be the value of the following Python expression? print(4 + 3 % 5)', '7', '2', '4', '1', 'A', 1, '2025-09-05 16:25:45'),
(18, 6, 14, 0, 'Which of the following is used to define a block of code in Python language?', 'Indentation', 'Key', 'Brackets', 'All of the mentioned', 'A', 1, '2025-09-05 16:25:45'),
(19, 6, 14, 0, 'Which keyword is used for function in Python language?', 'Function', 'def', 'Fun', 'Define', 'B', 1, '2025-09-05 16:25:45'),
(20, 6, 14, 0, 'Which of the following character is used to give single-line comments in Python?', '//', '#', '!', '/*', 'B', 1, '2025-09-05 16:25:45'),
(21, 6, 14, 0, 'What is the capital of India?', 'Mumbai', 'Chennai', 'New Delhi', 'Kolkata', 'C', 1, '2025-09-07 06:28:03'),
(22, 6, 14, 0, 'Which data type is used to store decimal values in MySQL?', 'INT', 'VARCHAR', 'FLOAT', 'BOOLEAN', 'C', 1, '2025-09-07 06:28:03'),
(23, 6, 14, 0, 'HTML stands for?', 'Hyperlinks and Text Markup Language', 'Hyper Text Markup Language', 'Home Tool Markup Language', 'High Transfer Markup Language', 'B', 1, '2025-09-07 06:28:03'),
(24, 6, 14, 0, 'Which SQL command is used to extract data from a database?', 'GET', 'EXTRACT', 'SELECT', 'SHOW', 'C', 1, '2025-09-07 06:28:03'),
(25, 6, 14, 0, 'Which of the following is a valid variable name in Python?', '1variable', 'variable_1', 'variable-1', 'variable one', 'B', 1, '2025-09-24 05:44:02'),
(26, 6, 14, 0, 'What is the correct way to assign a value to a variable in Python?', 'x := 10', 'x << 10', 'x = 10', 'x == 10', 'C', 1, '2025-09-24 05:44:02'),
(27, 6, 14, 0, 'Which keyword is used to declare a constant variable in Python?', 'let', 'const', 'final', 'None of the above', 'D', 1, '2025-09-24 05:44:02'),
(28, 6, 14, 0, 'What will be the output of: x, y = 10, 20; print(x, y)', '10 10', '20 10', '10 20', 'Error', 'C', 1, '2025-09-24 05:44:02'),
(29, 6, 14, 0, 'What type of variable is created when you assign: name = \'Hari\'?', 'Integer', 'String', 'Float', 'Boolean', 'B', 1, '2025-09-24 05:44:02'),
(30, 6, 14, 0, 'Which of these is NOT a valid assignment in Python?', 'a = b = c = 5', 'x, y, z = 1, 2, 3', 'm = 5; n = 10', '10 = x', 'D', 1, '2025-09-24 05:44:02'),
(31, 6, 14, 0, 'Which function is used to check the type of a variable in Python?', 'typeof()', 'type()', 'checktype()', 'vartype()', 'B', 1, '2025-09-24 05:44:02'),
(32, 6, 14, 0, 'What will be the output of: a = 5; b = a; a = 10; print(b)', '5', '10', '15', 'Error', 'A', 1, '2025-09-24 05:44:02'),
(33, 6, 14, 0, 'Which of the following variable names follows Python naming rules?', '_varName', 'var-name', 'var name', '123var', 'A', 1, '2025-09-24 05:44:02'),
(34, 6, 14, 0, 'What will be the type of variable x after execution: x = 10.0', 'int', 'str', 'float', 'bool', 'C', 1, '2025-09-24 05:44:02'),
(35, 6, 33, 0, 'What is the capital of India?', 'Mumbai', 'Chennai', 'New Delhi', 'Kolkata', 'C', 1, '2025-09-27 06:58:19'),
(36, 6, 33, 0, 'Which data type is used to store decimal values in MySQL?', 'INT', 'VARCHAR', 'FLOAT', 'BOOLEAN', 'C', 1, '2025-09-27 06:58:19'),
(37, 6, 33, 0, 'HTML stands for?', 'Hyperlinks and Text Markup Language', 'Hyper Text Markup Language', 'Home Tool Markup Language', 'High Transfer Markup Language', 'B', 1, '2025-09-27 06:58:19'),
(38, 6, 33, 0, 'Which SQL command is used to extract data from a database?', 'GET', 'EXTRACT', 'SELECT', 'SHOW', 'C', 1, '2025-09-27 06:58:19'),
(39, 8, 12, 0, 'What is C#?', 'A programming language developed by Microsoft', 'A web framework', 'A database management system', 'An operating system', 'A', 1, '2025-10-04 09:13:45'),
(40, 8, 12, 0, 'Which of the following is the correct extension for a C# source file?', '.cs', '.cpp', '.java', '.py', 'B', 1, '2025-10-04 09:13:45'),
(41, 8, 12, 0, 'In C#, what does CLR stand for?', 'Common Language Runtime', 'Common Library Resources', 'Code Line Reader', 'Class Library Repository', 'A', 1, '2025-10-04 09:13:45'),
(42, 8, 12, 0, 'Which keyword is used to declare a variable in C#?', 'var', 'let', 'const', 'define', 'A', 1, '2025-10-04 09:13:45'),
(43, 8, 12, 0, 'Which data type in C# is used to store integer values?', 'int', 'float', 'string', 'bool', 'A', 1, '2025-10-04 09:13:45'),
(44, 8, 12, 0, 'In C#, how do you output text to the console?', 'Console.WriteLine()', 'print()', 'cout <<', 'System.out.println', 'A', 1, '2025-10-04 09:13:45'),
(45, 8, 12, 0, 'What is the purpose of the Main() method in C#?', 'It is the entry point of the program', 'It declares variables', 'It handles exceptions', 'It defines classes', 'A', 1, '2025-10-04 09:13:45'),
(46, 8, 12, 0, 'Which symbol is used to end a statement in C#?', ';', '.', '!', '?', 'A', 1, '2025-10-04 09:13:45'),
(47, 8, 12, 0, 'In C#, what does the using directive do?', 'Imports namespaces', 'Declares variables', 'Defines methods', 'Handles errors', 'A', 1, '2025-10-04 09:13:45'),
(48, 8, 12, 0, 'What is an assembly in .NET?', 'A compiled code library', 'A source code file', 'A database table', 'An executable program', 'A', 1, '2025-10-04 09:13:45'),
(49, 8, 12, 0, 'Which access modifier allows a member to be accessed only within its own class?', 'private', 'public', 'protected', 'internal', 'A', 1, '2025-10-04 09:13:45'),
(50, 8, 12, 0, 'In C#, how do you create a comment for a single line?', '//', '/* */', '#', '**', 'A', 1, '2025-10-04 09:13:45'),
(51, 8, 12, 0, 'What is the data type used for floating-point numbers in C#?', 'float', 'double', 'char', 'byte', 'A', 1, '2025-10-04 09:13:45'),
(52, 8, 12, 0, 'Which operator is used for string concatenation in C#?', '#ERROR!', '*', '/', '%', 'A', 1, '2025-10-04 09:13:45'),
(53, 8, 12, 0, 'In C#, what does the \'new\' keyword do?', 'Allocates memory for an object', 'Declares a variable', 'Imports a namespace', 'Handles exceptions', 'A', 1, '2025-10-04 09:13:45'),
(54, 8, 12, 0, 'What is a namespace in C#?', 'A way to organize code', 'A data type', 'A method', 'An access modifier', 'A', 1, '2025-10-04 09:13:45'),
(55, 8, 12, 0, 'Which loop is used for iterating a specific number of times in C#?', 'for', 'while', 'do-while', 'foreach', 'A', 1, '2025-10-04 09:13:45'),
(56, 8, 12, 0, 'In C#, what is the correct way to declare an integer array?', 'int[] arr = new int[5];', 'array<int> arr;', 'int arr[5];', 'var arr = [5];', 'A', 1, '2025-10-04 09:13:45'),
(57, 8, 12, 0, 'What does the \'static\' keyword mean in C#?', 'The member belongs to the class, not an instance', 'The member is private', 'The member is a variable', 'The member is a method without return type', 'A', 1, '2025-10-04 09:13:45'),
(58, 8, 12, 0, 'In .NET, what is the role of the Garbage Collector?', 'Automatically manages memory', 'Compiles code', 'Handles user input', 'Reads files', 'A', 1, '2025-10-04 09:13:45'),
(59, 8, 12, 0, 'Which method is used to read input from the console in C#?', 'Console.ReadLine()', 'Input.Read()', 'scanf()', 'cin >>', 'A', 1, '2025-10-04 09:13:45'),
(60, 8, 12, 0, 'In C#, what is the base class for all classes?', 'Object', 'System', 'Console', 'String', 'A', 1, '2025-10-04 09:13:45'),
(61, 8, 12, 0, 'What is the syntax to create a class in C#?', 'class MyClass {}', 'public class MyClass;', 'interface MyClass;', 'struct MyClass;', 'B', 1, '2025-10-04 09:13:45'),
(62, 8, 12, 0, 'Which conditional statement is used in C#?', 'if-else', 'switch-case', 'both A and B', 'neither A nor B', 'C', 1, '2025-10-04 09:13:45'),
(63, 8, 12, 0, 'In C#, what does \'void\' mean as a return type?', 'The method does not return a value', 'The method returns a string', 'The method returns an integer', 'The method returns an object', 'A', 1, '2025-10-04 09:13:45'),
(64, 8, 12, 0, 'What is a method in C#?', 'A block of code that performs a specific task', 'A variable declaration', 'A class definition', 'A loop construct', 'A', 1, '2025-10-04 09:13:45'),
(65, 8, 12, 0, 'In C#, how do you include the System namespace?', 'using System;', 'import System;', 'require System;', 'include System;', 'A', 1, '2025-10-04 09:13:45'),
(66, 8, 12, 0, 'What is the default access modifier for class members in C#?', 'private', 'public', 'protected', 'internal', 'A', 1, '2025-10-04 09:13:45'),
(67, 8, 12, 0, 'Which of the following is a value type in C#?', 'string', 'int', 'class', 'bool', 'B', 1, '2025-10-04 09:13:45'),
(68, 9, 33, 0, 'What is the capital of India?', 'Mumbai', 'Chennai', 'New Delhi', 'Kolkata', 'C', 1, '2025-10-10 09:10:04'),
(69, 9, 33, 0, 'Which data type is used to store decimal values in MySQL?', 'INT', 'VARCHAR', 'FLOAT', 'BOOLEAN', 'C', 1, '2025-10-10 09:10:04'),
(70, 9, 33, 0, 'HTML stands for?', 'Hyperlinks and Text Markup Language', 'Hyper Text Markup Language', 'Home Tool Markup Language', 'High Transfer Markup Language', 'B', 1, '2025-10-10 09:10:04'),
(71, 9, 33, 0, 'Which SQL command is used to extract data from a database?', 'GET', 'EXTRACT', 'SELECT', 'SHOW', 'C', 1, '2025-10-10 09:10:04'),
(72, 11, 27, NULL, '#include <stdio.h>\nint main(){int x=5; if(x>3) printf(\"Yes\"); else printf(\"No\");}', 'Yes', 'No', 'Error', 'None', 'A', 2, '2025-10-31 06:49:48'),
(73, 11, 27, NULL, '#include <stdio.h>\nint main(){int i=1; while(i<=3){printf(\"%d \",i); i++;}}', '1 2 3', '1 2 3 4', 'Infinite Loop', '0 1 2', 'A', 2, '2025-10-31 06:49:48'),
(74, 11, 27, NULL, '#include <stdio.h>\nint main(){int i; for(i=0;i<3;i++) printf(\"%d\",i);}', '012', '123', '321', '0 1 2', 'A', 2, '2025-10-31 06:49:48'),
(75, 11, 27, NULL, '#include <stdio.h>\nint main(){int i=5; do{printf(\"%d\",i); i++;}while(i<5);}', '5', '4', 'None', 'Infinite Loop', 'A', 2, '2025-10-31 06:49:48'),
(76, 11, 27, NULL, '#include <stdio.h>\nint main(){int i=1; if(i=0) printf(\"True\"); else printf(\"False\");}', 'True', 'False', 'Error', 'None', 'B', 2, '2025-10-31 06:49:48'),
(77, 11, 27, NULL, '#include <stdio.h>\nint main(){for(int i=1;i<=5;i+=2) printf(\"%d \",i);}', '1 2 3 4 5', '1 3 5', '2 4', '1 2 3', 'B', 2, '2025-10-31 06:49:48'),
(78, 11, 27, NULL, '#include <stdio.h>\nint main(){int sum=0; for(int i=1;i<=3;i++) sum+=i; printf(\"%d\",sum);}', '3', '4', '6', '7', 'C', 2, '2025-10-31 06:49:48'),
(79, 11, 27, NULL, '#include <stdio.h>\nint main(){int a[]={1,2,3,4}; printf(\"%d\",a[2]);}', '1', '2', '3', '4', 'C', 2, '2025-10-31 06:49:48'),
(80, 11, 27, NULL, '#include <stdio.h>\nint main(){int a[]={10,20,30}; printf(\"%d\",*(a+1));}', '10', '20', '30', 'Garbage', 'B', 2, '2025-10-31 06:49:48'),
(81, 11, 27, NULL, '#include <stdio.h>\nint main(){int a[3]={1,2,3}; for(int i=0;i<3;i++) printf(\"%d\",a[i]);}', '123', '321', '132', 'Error', 'A', 2, '2025-10-31 06:49:48'),
(82, 12, 27, 0, 'What is 20% of 250?', '40', '45', '50', '60', 'C', 1, '2025-11-10 07:01:12'),
(83, 12, 27, 0, 'If the price of a shirt increases from ₹400 to ₹500, what is the percentage increase?', '20%', '22%', '25%', '30%', 'C', 1, '2025-11-10 07:01:12'),
(84, 12, 27, 0, 'If a number is increased by 10% and then decreased by 10%, what is the overall percentage change?', 'No change', '1% increase', '1% decrease', '2% decrease', 'C', 1, '2025-11-10 07:01:12'),
(85, 12, 27, 0, 'The population of a city increases by 20% in the first year and 10% in the second year. Find the overall percentage increase.', '30%', '31%', '32%', '33%', 'C', 1, '2025-11-10 07:01:12'),
(86, 12, 27, 0, 'A man spends 60% of his income and saves ₹6,000. Find his total income.', '₹12,000', '₹13,000', '₹14,000', '₹15,000', 'D', 1, '2025-11-10 07:01:12'),
(87, 12, 27, 0, 'The ratio of two numbers is 3:5. If their sum is 80, find the numbers.', '30 and 50', '32 and 48', '20 and 60', '25 and 55', 'A', 1, '2025-11-10 07:01:12'),
(88, 12, 27, 0, 'If 3:x = 9:18, find the value of x.', '4', '5', '6', '7', 'C', 1, '2025-11-10 07:01:12'),
(89, 12, 27, 0, 'A can complete a piece of work in 10 days, and B can do it in 15 days. How long will they take to finish it together?', '5', '6', '7', '8', 'B', 1, '2025-11-10 07:01:12'),
(90, 12, 27, 0, 'A alone can do a work in 12 days, B alone in 16 days. A and B work 4 days together, then A leaves. In how many days will B finish?', '6', '7', '8', '9', 'B', 1, '2025-11-10 07:01:12'),
(91, 12, 27, 0, 'Find the average of 12, 18, 24, and 30.', '20', '21', '22', '23', 'B', 1, '2025-11-10 07:01:12'),
(92, 12, 27, 0, 'The average of 5 numbers is 28. If one number is removed, the average becomes 26. Find the removed number.', '28', '30', '36', '38', 'C', 1, '2025-11-10 07:01:12'),
(93, 12, 27, 0, 'The average weight of 4 boys is 60 kg. If a fifth boy joins, average increases by 2 kg. Find new boy’s weight.', '64', '66', '70', '72', 'C', 1, '2025-11-10 07:01:12'),
(94, 12, 27, 0, 'Find the simple interest on ₹5000 for 3 years at 8% p.a.', '₹800', '₹1000', '₹1200', '₹1500', 'C', 1, '2025-11-10 07:01:12'),
(95, 12, 27, 0, 'Find the compound interest on ₹10,000 for 2 years at 10% p.a.', '₹1000', '₹2000', '₹2100', '₹2200', 'C', 1, '2025-11-10 07:01:12'),
(96, 12, 27, 0, 'A dice is rolled once. Find the probability of getting an even number.', '1/2', '1/3', '2/3', '1/6', 'A', 1, '2025-11-10 07:01:12'),
(97, 12, 27, 0, 'Two coins are tossed together. Find the probability of getting at least one head.', '1/4', '1/2', '3/4', '2/3', 'C', 1, '2025-11-10 07:01:12'),
(98, 12, 27, 0, 'How many ways can the letters of the word “CAT” be arranged?', '3', '4', '6', '9', 'C', 1, '2025-11-10 07:01:12'),
(99, 12, 27, 0, 'How many 3-digit numbers can be formed using digits 1,2,3,4 without repetition?', '12', '24', '36', '48', 'B', 1, '2025-11-10 07:01:12'),
(100, 12, 27, 0, 'A pipe can fill a tank in 6 hours. How much part will be filled in 2 hours?', '1/2', '1/3', '1/4', '1/6', 'B', 1, '2025-11-10 07:01:12'),
(101, 12, 27, 0, 'A boat goes 12 km downstream in 3 hr and returns upstream in 4 hr. Find boat & stream speed.', '3,1', '4,1', '5,1', '3.5,0.5', 'D', 1, '2025-11-10 07:01:12');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'student'),
(2, 'faculty'),
(3, 'hod'),
(4, 'vice_principal'),
(5, 'principal');

-- --------------------------------------------------------

--
-- Table structure for table `student_answers`
--

CREATE TABLE `student_answers` (
  `student_answers_id` int NOT NULL,
  `student_test_id` int NOT NULL,
  `question_id` int NOT NULL,
  `answer` text,
  `is_correct` tinyint(1) DEFAULT NULL,
  `marked_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_answers`
--

INSERT INTO `student_answers` (`student_answers_id`, `student_test_id`, `question_id`, `answer`, `is_correct`, `marked_at`) VALUES
(0, 1, 26, 'A', 0, '2025-11-11 19:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `student_tests`
--

CREATE TABLE `student_tests` (
  `student_test_id` int NOT NULL,
  `student_id` int NOT NULL,
  `test_id` int NOT NULL,
  `start_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `end_time` datetime DEFAULT NULL,
  `score` decimal(5,2) DEFAULT '0.00',
  `status` enum('started','completed') DEFAULT 'started'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_tests`
--

INSERT INTO `student_tests` (`student_test_id`, `student_id`, `test_id`, `start_time`, `end_time`, `score`, `status`) VALUES
(1, 32, 10, '2025-09-24 11:20:07', '2025-09-24 11:20:21', 1.00, 'completed'),
(2, 46, 11, '2025-09-24 15:26:24', '2025-09-24 15:33:05', 10.00, 'completed'),
(3, 41, 11, '2025-09-24 15:26:27', '2025-09-24 15:32:56', 9.00, 'completed'),
(4, 52, 11, '2025-09-24 15:26:31', '2025-09-24 15:31:12', 12.00, 'completed'),
(5, 42, 11, '2025-09-24 15:26:35', '2025-09-24 15:29:26', 10.00, 'completed'),
(6, 48, 11, '2025-09-24 15:26:36', '2025-09-24 15:28:03', 3.00, 'completed'),
(7, 56, 11, '2025-09-24 15:26:40', '2025-09-24 15:28:40', 11.00, 'completed'),
(8, 43, 11, '2025-09-24 15:26:41', '2025-09-24 15:30:31', 9.00, 'completed'),
(9, 55, 11, '2025-09-24 15:26:57', '2025-09-24 15:32:21', 12.00, 'completed'),
(10, 53, 11, '2025-09-24 15:27:24', '2025-09-24 15:31:27', 10.00, 'completed'),
(11, 50, 11, '2025-09-24 15:27:30', '2025-09-24 15:28:27', 3.00, 'completed'),
(12, 57, 11, '2025-09-24 15:27:58', '2025-09-24 15:31:46', 12.00, 'completed'),
(13, 40, 11, '2025-09-24 15:28:20', '2025-09-24 15:30:08', 5.00, 'completed'),
(14, 39, 11, '2025-09-24 15:28:29', '2025-09-24 15:28:53', 0.00, 'completed'),
(15, 67, 11, '2025-09-24 15:28:29', '2025-09-24 15:29:21', 0.00, 'completed'),
(16, 69, 11, '2025-09-24 15:28:34', '2025-09-24 15:28:56', 0.00, 'completed'),
(17, 81, 11, '2025-09-24 15:28:37', '2025-09-24 15:32:35', 10.00, 'completed'),
(18, 54, 11, '2025-09-24 15:29:35', '2025-09-24 15:32:42', 4.00, 'completed'),
(19, 45, 11, '2025-09-24 15:30:11', '2025-09-24 15:32:32', 6.00, 'completed'),
(20, 60, 11, '2025-09-24 15:30:12', '2025-09-24 15:34:20', 10.00, 'completed'),
(21, 79, 11, '2025-09-24 15:30:14', '2025-09-24 15:34:05', 10.00, 'completed'),
(22, 77, 11, '2025-09-24 15:31:28', '2025-09-24 15:34:54', 5.00, 'completed'),
(23, 63, 11, '2025-09-24 15:32:43', '2025-09-24 15:34:49', 4.00, 'completed'),
(24, 70, 11, '2025-09-24 15:33:52', '2025-09-24 15:34:50', 5.00, 'completed'),
(25, 84, 14, '2025-10-04 14:49:23', '2025-10-04 15:45:47', 8.00, 'completed'),
(26, 121, 14, '2025-10-04 15:40:00', '2025-10-04 15:49:14', 19.00, 'completed'),
(27, 110, 14, '2025-10-04 15:40:19', '2025-10-04 15:50:41', 21.00, 'completed'),
(28, 115, 14, '2025-10-04 15:40:20', '2025-10-04 15:43:16', 14.00, 'completed'),
(29, 98, 14, '2025-10-04 15:40:20', '2025-10-04 15:49:59', 20.00, 'completed'),
(30, 113, 14, '2025-10-04 15:40:24', '2025-10-04 15:46:37', 18.00, 'completed'),
(31, 111, 14, '2025-10-04 15:40:30', '2025-10-04 15:45:11', 19.00, 'completed'),
(32, 99, 14, '2025-10-04 15:40:30', '2025-10-04 15:56:05', 18.00, 'completed'),
(33, 133, 14, '2025-10-04 15:40:33', '2025-10-04 15:48:49', 16.00, 'completed'),
(34, 122, 14, '2025-10-04 15:40:42', '2025-10-04 15:54:36', 19.00, 'completed'),
(35, 114, 14, '2025-10-04 15:41:04', '2025-10-04 15:49:48', 22.00, 'completed'),
(36, 97, 14, '2025-10-04 15:41:16', '2025-10-04 15:49:56', 24.00, 'completed'),
(37, 106, 14, '2025-10-04 15:41:23', '2025-10-04 15:50:39', 15.00, 'completed'),
(38, 131, 14, '2025-10-04 15:41:24', '2025-10-04 15:49:03', 21.00, 'completed'),
(39, 132, 14, '2025-10-04 15:41:28', '2025-10-04 15:47:35', 18.00, 'completed'),
(40, 109, 14, '2025-10-04 15:41:32', '2025-10-04 15:52:45', 15.00, 'completed'),
(41, 84, 14, '2025-10-04 15:41:34', NULL, 0.00, 'started'),
(42, 84, 14, '2025-10-04 15:41:35', NULL, 0.00, 'started'),
(43, 101, 14, '2025-10-04 15:41:39', '2025-10-04 15:49:00', 24.00, 'completed'),
(44, 88, 14, '2025-10-04 15:41:42', '2025-10-04 15:44:35', 0.00, 'completed'),
(45, 138, 14, '2025-10-04 15:41:45', '2025-10-04 15:52:55', 21.00, 'completed'),
(46, 123, 14, '2025-10-04 15:41:46', '2025-10-04 15:48:33', 19.00, 'completed'),
(47, 112, 14, '2025-10-04 15:42:01', '2025-10-04 15:44:57', 8.00, 'completed'),
(48, 89, 14, '2025-10-04 15:42:09', '2025-10-04 15:54:08', 10.00, 'completed'),
(49, 134, 14, '2025-10-04 15:42:14', '2025-10-04 15:52:40', 18.00, 'completed'),
(50, 102, 14, '2025-10-04 15:42:54', '2025-10-04 15:54:19', 17.00, 'completed'),
(51, 100, 14, '2025-10-04 15:42:58', '2025-10-04 15:52:42', 21.00, 'completed'),
(52, 128, 14, '2025-10-04 15:43:06', '2025-10-04 15:54:38', 20.00, 'completed'),
(53, 119, 14, '2025-10-04 15:43:29', '2025-10-04 15:51:58', 23.00, 'completed'),
(54, 89, 14, '2025-10-04 15:43:35', NULL, 0.00, 'started'),
(55, 87, 14, '2025-10-04 15:43:36', '2025-10-04 15:51:40', 10.00, 'completed'),
(56, 85, 14, '2025-10-04 15:43:36', '2025-10-04 15:50:58', 10.00, 'completed'),
(57, 90, 14, '2025-10-04 15:44:13', '2025-10-04 15:54:02', 14.00, 'completed'),
(58, 141, 14, '2025-10-04 15:44:52', '2025-10-04 15:55:40', 18.00, 'completed'),
(59, 136, 14, '2025-10-04 15:45:59', '2025-10-04 15:54:59', 18.00, 'completed'),
(60, 125, 14, '2025-10-04 15:46:29', '2025-10-04 15:53:04', 21.00, 'completed'),
(61, 139, 14, '2025-10-04 15:46:56', '2025-10-04 15:52:20', 23.00, 'completed'),
(62, 92, 14, '2025-10-04 15:48:07', '2025-10-04 15:53:01', 21.00, 'completed'),
(63, 146, 14, '2025-10-04 15:48:56', '2025-10-04 15:56:18', 12.00, 'completed'),
(64, 120, 14, '2025-10-04 15:50:04', '2025-10-04 15:55:01', 16.00, 'completed'),
(65, 142, 14, '2025-10-04 15:50:09', '2025-10-04 15:50:37', 0.00, 'completed'),
(66, 96, 14, '2025-10-04 15:52:33', '2025-10-04 15:57:31', 25.00, 'completed'),
(67, 135, 14, '2025-10-04 15:56:09', '2025-10-04 16:01:02', 22.00, 'completed'),
(68, 126, 14, '2025-10-04 15:57:27', '2025-10-04 15:59:47', 10.00, 'completed'),
(69, 32, 15, '2025-10-10 14:46:07', '2025-10-10 14:47:21', 1.00, 'completed'),
(70, 68, 16, '2025-10-31 12:26:08', NULL, 0.00, 'started'),
(71, 180, 16, '2025-11-04 06:05:07', '2025-11-04 06:12:04', 8.00, 'completed'),
(72, 180, 16, '2025-11-04 06:05:30', NULL, 0.00, 'started'),
(73, 185, 16, '2025-11-04 17:50:05', NULL, 0.00, 'started'),
(74, 185, 16, '2025-11-04 17:51:13', NULL, 0.00, 'started'),
(75, 185, 16, '2025-11-04 17:51:30', NULL, 0.00, 'started'),
(76, 160, 16, '2025-11-04 18:55:53', '2025-11-04 19:03:24', 0.00, 'completed'),
(77, 160, 16, '2025-11-04 18:56:14', NULL, 0.00, 'started'),
(78, 149, 16, '2025-11-04 18:56:25', '2025-11-04 18:59:50', 6.00, 'completed'),
(79, 160, 16, '2025-11-04 18:56:46', NULL, 0.00, 'started'),
(80, 160, 16, '2025-11-04 18:56:55', NULL, 0.00, 'started'),
(81, 160, 16, '2025-11-04 18:58:11', NULL, 0.00, 'started'),
(82, 192, 16, '2025-11-04 18:59:29', '2025-11-04 19:02:45', 8.00, 'completed'),
(83, 149, 16, '2025-11-04 19:00:00', NULL, 0.00, 'started'),
(84, 171, 16, '2025-11-04 19:01:59', '2025-11-04 19:14:56', 10.00, 'completed'),
(85, 171, 16, '2025-11-04 19:02:14', NULL, 0.00, 'started'),
(86, 160, 16, '2025-11-04 19:03:04', NULL, 0.00, 'started'),
(87, 205, 16, '2025-11-04 19:04:27', '2025-11-04 19:07:31', 10.00, 'completed'),
(88, 176, 16, '2025-11-04 19:05:49', '2025-11-05 19:20:18', 10.00, 'completed'),
(89, 176, 16, '2025-11-04 19:06:03', NULL, 0.00, 'started'),
(90, 154, 16, '2025-11-04 19:06:08', '2025-11-04 19:09:17', 2.00, 'completed'),
(91, 167, 16, '2025-11-04 19:06:30', '2025-11-04 19:10:40', 10.00, 'completed'),
(92, 154, 16, '2025-11-04 19:06:38', NULL, 0.00, 'started'),
(93, 176, 16, '2025-11-04 19:07:19', NULL, 0.00, 'started'),
(94, 171, 16, '2025-11-04 19:12:52', NULL, 0.00, 'started'),
(95, 171, 16, '2025-11-04 19:13:10', NULL, 0.00, 'started'),
(96, 176, 16, '2025-11-04 19:16:40', NULL, 0.00, 'started'),
(97, 176, 16, '2025-11-04 19:17:49', NULL, 0.00, 'started'),
(98, 177, 16, '2025-11-04 19:18:55', '2025-11-04 19:37:44', 8.00, 'completed'),
(99, 177, 16, '2025-11-04 19:26:03', NULL, 0.00, 'started'),
(100, 177, 16, '2025-11-04 19:26:25', NULL, 0.00, 'started'),
(101, 177, 16, '2025-11-04 19:30:25', NULL, 0.00, 'started'),
(102, 177, 16, '2025-11-04 19:30:31', NULL, 0.00, 'started'),
(103, 177, 16, '2025-11-04 19:32:20', NULL, 0.00, 'started'),
(104, 198, 16, '2025-11-04 19:35:39', '2025-11-04 21:29:37', 8.00, 'completed'),
(105, 198, 16, '2025-11-04 19:36:02', NULL, 0.00, 'started'),
(106, 198, 16, '2025-11-04 19:36:02', NULL, 0.00, 'started'),
(107, 198, 16, '2025-11-04 19:37:08', NULL, 0.00, 'started'),
(108, 187, 16, '2025-11-04 19:51:50', NULL, 0.00, 'started'),
(109, 196, 16, '2025-11-04 19:54:44', '2025-11-04 21:28:49', 10.00, 'completed'),
(110, 196, 16, '2025-11-04 19:54:47', NULL, 0.00, 'started'),
(111, 196, 16, '2025-11-04 19:55:12', NULL, 0.00, 'started'),
(112, 196, 16, '2025-11-04 19:56:09', NULL, 0.00, 'started'),
(113, 196, 16, '2025-11-04 19:58:40', NULL, 0.00, 'started'),
(114, 196, 16, '2025-11-04 19:58:47', NULL, 0.00, 'started'),
(115, 196, 16, '2025-11-04 19:58:51', NULL, 0.00, 'started'),
(116, 196, 16, '2025-11-04 19:59:01', NULL, 0.00, 'started'),
(117, 196, 16, '2025-11-04 21:22:53', NULL, 0.00, 'started'),
(118, 198, 16, '2025-11-04 21:23:31', NULL, 0.00, 'started'),
(119, 196, 16, '2025-11-04 21:23:53', NULL, 0.00, 'started'),
(120, 198, 16, '2025-11-04 21:29:58', NULL, 0.00, 'started'),
(121, 198, 16, '2025-11-04 21:29:59', NULL, 0.00, 'started'),
(122, 153, 16, '2025-11-04 21:31:14', '2025-11-04 21:36:20', 0.00, 'completed'),
(123, 153, 16, '2025-11-04 21:36:16', NULL, 0.00, 'started'),
(124, 186, 16, '2025-11-04 21:40:53', '2025-11-04 21:51:54', 4.00, 'completed'),
(125, 183, 16, '2025-11-04 22:24:20', '2025-11-04 22:32:22', 10.00, 'completed'),
(126, 170, 16, '2025-11-04 22:38:22', '2025-11-04 22:46:39', 10.00, 'completed'),
(127, 170, 16, '2025-11-04 22:39:21', NULL, 0.00, 'started'),
(128, 173, 16, '2025-11-04 22:47:48', '2025-11-04 22:51:17', 6.00, 'completed'),
(129, 155, 16, '2025-11-05 06:22:18', '2025-11-05 06:22:39', 0.00, 'completed'),
(130, 179, 16, '2025-11-05 06:23:46', '2025-11-05 06:26:15', 8.00, 'completed'),
(131, 197, 16, '2025-11-05 07:09:49', '2025-11-05 07:13:46', 10.00, 'completed'),
(132, 197, 16, '2025-11-05 07:10:15', NULL, 0.00, 'started'),
(133, 197, 16, '2025-11-05 07:11:14', NULL, 0.00, 'started'),
(134, 197, 16, '2025-11-05 07:11:35', NULL, 0.00, 'started'),
(135, 191, 16, '2025-11-05 07:29:14', '2025-11-05 07:33:41', 10.00, 'completed'),
(136, 161, 16, '2025-11-05 08:22:44', '2025-11-05 08:24:50', 4.00, 'completed'),
(137, 161, 16, '2025-11-05 08:23:04', NULL, 0.00, 'started'),
(138, 68, 16, '2025-11-05 16:52:23', NULL, 0.00, 'started'),
(139, 176, 16, '2025-11-05 17:13:54', NULL, 0.00, 'started'),
(140, 204, 16, '2025-11-05 18:10:14', '2025-11-05 18:15:41', 6.00, 'completed'),
(141, 204, 16, '2025-11-05 18:10:16', NULL, 0.00, 'started'),
(142, 204, 16, '2025-11-05 18:10:26', NULL, 0.00, 'started'),
(143, 204, 16, '2025-11-05 18:10:27', NULL, 0.00, 'started'),
(144, 32, 16, '2025-11-05 18:14:23', NULL, 0.00, 'started'),
(145, 176, 16, '2025-11-05 19:16:10', NULL, 0.00, 'started'),
(146, 176, 16, '2025-11-05 19:16:11', NULL, 0.00, 'started'),
(147, 176, 16, '2025-11-05 19:16:12', NULL, 0.00, 'started'),
(148, 176, 16, '2025-11-05 19:16:13', NULL, 0.00, 'started'),
(149, 176, 16, '2025-11-05 19:16:13', NULL, 0.00, 'started'),
(150, 176, 16, '2025-11-05 19:16:15', NULL, 0.00, 'started'),
(151, 176, 16, '2025-11-05 19:16:16', NULL, 0.00, 'started'),
(152, 147, 16, '2025-11-05 19:18:53', '2025-11-05 19:19:26', 0.00, 'completed'),
(153, 176, 16, '2025-11-05 19:18:55', NULL, 0.00, 'started'),
(154, 176, 16, '2025-11-05 19:18:56', NULL, 0.00, 'started'),
(155, 176, 16, '2025-11-05 19:18:57', NULL, 0.00, 'started'),
(156, 147, 16, '2025-11-05 19:19:07', NULL, 0.00, 'started'),
(157, 147, 16, '2025-11-05 19:19:31', NULL, 0.00, 'started'),
(158, 157, 16, '2025-11-05 19:20:06', '2025-11-05 19:25:25', 4.00, 'completed'),
(159, 157, 16, '2025-11-05 19:21:51', NULL, 0.00, 'started'),
(160, 157, 16, '2025-11-05 19:22:47', NULL, 0.00, 'started'),
(161, 162, 16, '2025-11-05 19:37:32', '2025-11-05 19:45:25', 8.00, 'completed'),
(162, 162, 16, '2025-11-05 19:37:47', NULL, 0.00, 'started'),
(163, 162, 16, '2025-11-05 19:38:17', NULL, 0.00, 'started'),
(164, 156, 16, '2025-11-05 19:38:17', '2025-11-05 19:42:56', 10.00, 'completed'),
(165, 156, 16, '2025-11-05 19:39:31', NULL, 0.00, 'started'),
(166, 156, 16, '2025-11-05 19:39:44', NULL, 0.00, 'started'),
(167, 202, 16, '2025-11-05 21:54:33', NULL, 0.00, 'started'),
(168, 159, 16, '2025-11-06 18:59:46', '2025-11-06 19:01:02', 0.00, 'completed'),
(169, 66, 12, '2025-11-10 12:24:07', '2025-11-10 14:24:07', 9.00, 'completed'),
(170, 68, 17, '2025-11-10 12:33:58', NULL, 0.00, 'started'),
(171, 63, 17, '2025-11-10 13:47:05', '2025-11-10 13:48:18', 1.00, 'completed'),
(172, 65, 17, '2025-11-10 13:50:41', '2025-11-10 13:51:19', 0.00, 'completed'),
(173, 72, 17, '2025-11-10 13:51:20', '2025-11-10 14:03:35', 10.00, 'completed'),
(174, 72, 17, '2025-11-10 13:51:21', NULL, 0.00, 'started'),
(175, 71, 17, '2025-11-10 13:53:22', '2025-11-10 13:53:45', 0.00, 'completed'),
(176, 61, 17, '2025-11-10 13:53:53', '2025-11-10 14:03:12', 10.00, 'completed'),
(177, 60, 17, '2025-11-10 13:54:32', '2025-11-10 14:12:43', 5.00, 'completed'),
(178, 62, 17, '2025-11-10 13:56:18', '2025-11-10 14:06:59', 3.00, 'completed'),
(179, 59, 17, '2025-11-10 13:59:49', '2025-11-10 14:09:48', 4.00, 'completed'),
(180, 72, 13, '2025-11-10 14:04:06', '2025-11-10 14:11:03', 9.00, 'completed'),
(181, 66, 17, '2025-11-10 14:10:06', '2025-11-10 14:10:59', 10.00, 'completed'),
(182, 65, 13, '2025-11-10 14:11:09', '2025-11-10 14:12:20', 9.00, 'completed'),
(183, 66, 13, '2025-11-10 14:11:35', '2025-11-10 14:13:25', 9.00, 'completed'),
(184, 72, 12, '2025-11-10 14:13:11', '2025-11-10 14:18:12', 10.00, 'completed'),
(185, 61, 13, '2025-11-10 14:13:49', '2025-11-10 14:14:42', 9.00, 'completed'),
(186, 61, 11, '2025-11-10 14:15:24', '2025-11-10 14:21:38', 13.00, 'completed'),
(187, 65, 12, '2025-11-10 14:18:17', '2025-11-10 14:19:15', 10.00, 'completed'),
(188, 72, 11, '2025-11-10 14:20:31', '2025-11-10 14:22:57', 12.00, 'completed'),
(189, 66, 11, '2025-11-10 14:21:42', '2025-11-10 14:22:49', 12.00, 'completed'),
(190, 61, 12, '2025-11-10 14:21:50', '2025-11-10 14:23:08', 9.00, 'completed'),
(191, 65, 11, '2025-11-10 14:22:58', '2025-11-10 14:24:14', 13.00, 'completed'),
(192, 66, 12, '2025-11-10 14:23:20', NULL, 0.00, 'started'),
(193, 79, 17, '2025-11-10 14:38:24', '2025-11-10 14:44:03', 2.00, 'completed'),
(194, 70, 17, '2025-11-10 14:43:33', '2025-11-10 14:46:57', 3.00, 'completed'),
(195, 74, 17, '2025-11-10 19:10:15', '2025-11-10 19:17:47', 9.00, 'completed'),
(196, 74, 11, '2025-11-10 19:18:22', '2025-11-10 19:22:40', 8.00, 'completed'),
(197, 74, 13, '2025-11-10 19:23:02', '2025-11-10 19:24:58', 5.00, 'completed'),
(198, 74, 12, '2025-11-10 19:25:12', '2025-11-10 19:29:35', 8.00, 'completed'),
(199, 80, 17, '2025-11-10 20:12:54', '2025-11-10 20:21:08', 9.00, 'completed'),
(200, 80, 13, '2025-11-10 20:25:17', '2025-11-10 20:31:09', 9.00, 'completed'),
(201, 80, 12, '2025-11-10 20:31:39', '2025-11-10 20:35:25', 10.00, 'completed'),
(202, 80, 11, '2025-11-10 20:36:15', '2025-11-10 20:46:40', 15.00, 'completed'),
(203, 175, 17, '2025-11-10 21:11:30', '2025-11-10 21:25:00', 9.00, 'completed'),
(204, 82, 17, '2025-11-10 21:55:11', '2025-11-10 21:59:50', 9.00, 'completed'),
(205, 82, 13, '2025-11-10 22:00:33', '2025-11-10 22:07:22', 10.00, 'completed'),
(206, 82, 12, '2025-11-10 22:07:52', '2025-11-10 22:12:23', 8.00, 'completed'),
(207, 82, 11, '2025-11-10 22:12:38', '2025-11-10 22:16:59', 15.00, 'completed'),
(208, 275, 18, '2025-11-11 16:16:41', '2025-11-11 16:21:45', 5.00, 'completed'),
(209, 288, 18, '2025-11-11 16:16:53', '2025-11-11 16:19:27', 2.00, 'completed'),
(210, 246, 18, '2025-11-11 16:18:41', '2025-11-11 16:25:07', 3.00, 'completed'),
(211, 288, 5, '2025-11-11 16:19:59', '2025-11-11 16:24:38', 4.00, 'completed'),
(212, 263, 18, '2025-11-11 16:20:35', '2025-11-11 16:28:49', 4.00, 'completed'),
(213, 293, 18, '2025-11-11 16:20:37', '2025-11-11 16:25:31', 0.00, 'completed'),
(214, 272, 18, '2025-11-11 16:20:38', '2025-11-11 16:28:28', 2.00, 'completed'),
(215, 257, 18, '2025-11-11 16:20:41', '2025-11-11 16:21:04', 0.00, 'completed'),
(216, 289, 18, '2025-11-11 16:20:45', '2025-11-11 16:23:09', 4.00, 'completed'),
(217, 291, 18, '2025-11-11 16:20:49', '2025-11-11 16:26:52', 3.00, 'completed'),
(218, 267, 18, '2025-11-11 16:20:49', '2025-11-11 16:28:58', 0.00, 'completed'),
(219, 282, 18, '2025-11-11 16:20:50', '2025-11-11 16:31:13', 5.00, 'completed'),
(220, 244, 18, '2025-11-11 16:20:50', '2025-11-11 16:26:58', 2.00, 'completed'),
(221, 283, 18, '2025-11-11 16:20:51', '2025-11-11 16:31:10', 1.00, 'completed'),
(222, 280, 18, '2025-11-11 16:20:53', '2025-11-11 16:24:15', 4.00, 'completed'),
(223, 254, 18, '2025-11-11 16:20:56', '2025-11-11 16:29:22', 5.00, 'completed'),
(224, 290, 18, '2025-11-11 16:20:56', '2025-11-11 16:29:08', 4.00, 'completed'),
(225, 255, 18, '2025-11-11 16:20:59', '2025-11-11 16:33:46', 5.00, 'completed'),
(226, 245, 18, '2025-11-11 16:20:59', '2025-11-11 16:23:16', 2.00, 'completed'),
(227, 256, 18, '2025-11-11 16:21:01', '2025-11-11 16:27:38', 6.00, 'completed'),
(228, 286, 18, '2025-11-11 16:21:01', '2025-11-11 16:29:17', 4.00, 'completed'),
(229, 296, 18, '2025-11-11 16:21:04', '2025-11-11 16:27:56', 4.00, 'completed'),
(230, 248, 18, '2025-11-11 16:21:09', '2025-11-11 16:24:34', 0.00, 'completed'),
(231, 269, 18, '2025-11-11 16:21:09', '2025-11-11 16:22:56', 1.00, 'completed'),
(232, 243, 18, '2025-11-11 16:21:11', '2025-11-11 16:27:28', 3.00, 'completed'),
(233, 292, 18, '2025-11-11 16:21:16', '2025-11-11 16:27:02', 5.00, 'completed'),
(234, 285, 18, '2025-11-11 16:21:20', '2025-11-11 16:27:55', 2.00, 'completed'),
(235, 274, 18, '2025-11-11 16:21:25', '2025-11-11 16:31:10', 7.00, 'completed'),
(236, 258, 18, '2025-11-11 16:21:55', '2025-11-11 16:33:46', 1.00, 'completed'),
(237, 265, 18, '2025-11-11 16:22:15', '2025-11-11 16:30:51', 6.00, 'completed'),
(238, 259, 18, '2025-11-11 16:22:15', '2025-11-11 16:32:17', 6.00, 'completed'),
(239, 266, 18, '2025-11-11 16:22:15', '2025-11-11 16:32:17', 5.00, 'completed'),
(240, 240, 18, '2025-11-11 16:22:16', '2025-11-11 16:32:25', 5.00, 'completed'),
(241, 261, 18, '2025-11-11 16:22:20', NULL, 0.00, 'started'),
(242, 279, 18, '2025-11-11 16:22:22', '2025-11-11 16:25:17', 2.00, 'completed'),
(243, 298, 18, '2025-11-11 16:22:23', '2025-11-11 16:26:29', 1.00, 'completed'),
(244, 276, 18, '2025-11-11 16:22:25', '2025-11-11 16:24:58', 1.00, 'completed'),
(245, 273, 18, '2025-11-11 16:22:28', '2025-11-11 16:29:16', 1.00, 'completed'),
(246, 287, 18, '2025-11-11 16:22:32', '2025-11-11 16:27:32', 1.00, 'completed'),
(247, 271, 18, '2025-11-11 16:22:34', '2025-11-11 16:27:45', 2.00, 'completed'),
(248, 281, 18, '2025-11-11 16:22:40', '2025-11-11 16:28:07', 2.00, 'completed'),
(249, 297, 18, '2025-11-11 16:22:41', '2025-11-11 16:27:27', 2.00, 'completed'),
(250, 249, 18, '2025-11-11 16:22:43', '2025-11-11 16:28:35', 2.00, 'completed'),
(251, 239, 18, '2025-11-11 16:24:41', '2025-11-11 16:32:25', 2.00, 'completed'),
(252, 288, 4, '2025-11-11 16:25:10', NULL, 0.00, 'started'),
(253, 261, 18, '2025-11-11 16:25:34', NULL, 0.00, 'started'),
(254, 288, 4, '2025-11-11 16:25:44', NULL, 0.00, 'started'),
(255, 251, 18, '2025-11-11 16:26:11', '2025-11-11 16:30:29', 4.00, 'completed'),
(256, 277, 18, '2025-11-11 16:26:25', '2025-11-11 16:33:47', 2.00, 'completed'),
(257, 262, 18, '2025-11-11 16:26:36', '2025-11-11 16:30:01', 2.00, 'completed'),
(258, 245, 5, '2025-11-11 16:26:43', '2025-11-11 16:28:04', 1.00, 'completed'),
(259, 293, 5, '2025-11-11 16:26:47', '2025-11-11 16:32:27', 7.00, 'completed'),
(260, 284, 18, '2025-11-11 16:26:49', '2025-11-11 16:34:26', 3.00, 'completed'),
(261, 259, 18, '2025-11-11 16:27:04', NULL, 0.00, 'started'),
(262, 250, 18, '2025-11-11 16:27:17', '2025-11-11 16:29:46', 1.00, 'completed'),
(263, 288, 4, '2025-11-11 16:27:23', NULL, 0.00, 'started'),
(264, 288, 4, '2025-11-11 16:27:57', NULL, 0.00, 'started'),
(265, 287, 5, '2025-11-11 16:28:00', NULL, 0.00, 'started'),
(266, 264, 18, '2025-11-11 16:28:08', '2025-11-11 16:34:12', 2.00, 'completed'),
(267, 245, 4, '2025-11-11 16:29:18', '2025-11-11 16:29:27', 0.00, 'completed'),
(268, 295, 18, '2025-11-11 16:29:56', '2025-11-11 16:33:46', 4.00, 'completed'),
(269, 278, 18, '2025-11-11 16:30:05', '2025-11-11 16:33:46', 5.00, 'completed'),
(270, 263, 5, '2025-11-11 16:30:05', '2025-11-11 16:33:46', 6.00, 'completed'),
(271, 262, 5, '2025-11-11 16:30:20', '2025-11-11 16:32:26', 1.00, 'completed'),
(272, 268, 18, '2025-11-11 16:30:48', '2025-11-11 16:32:25', 2.00, 'completed'),
(273, 262, 4, '2025-11-11 16:32:38', NULL, 0.00, 'started'),
(274, 253, 18, '2025-11-11 16:33:19', NULL, 0.00, 'started'),
(275, 253, 18, '2025-11-11 16:33:20', NULL, 0.00, 'started'),
(276, 253, 18, '2025-11-11 16:33:22', NULL, 0.00, 'started'),
(277, 253, 18, '2025-11-11 16:33:23', NULL, 0.00, 'started'),
(278, 293, 4, '2025-11-11 16:33:24', NULL, 0.00, 'started'),
(279, 253, 18, '2025-11-11 16:33:25', NULL, 0.00, 'started'),
(280, 262, 4, '2025-11-11 16:33:37', NULL, 0.00, 'started'),
(281, 253, 18, '2025-11-11 16:33:41', NULL, 0.00, 'started'),
(282, 253, 18, '2025-11-11 16:33:43', NULL, 0.00, 'started'),
(283, 241, 18, '2025-11-11 18:14:20', '2025-11-11 19:31:25', 10.00, 'completed'),
(284, 241, 18, '2025-11-11 18:14:48', NULL, 0.00, 'started'),
(285, 241, 18, '2025-11-11 18:17:10', NULL, 0.00, 'started'),
(286, 242, 18, '2025-11-11 18:18:32', '2025-11-11 19:47:21', 5.00, 'completed'),
(287, 241, 18, '2025-11-11 18:19:00', NULL, 0.00, 'started'),
(288, 242, 18, '2025-11-11 18:21:24', NULL, 0.00, 'started'),
(289, 242, 18, '2025-11-11 18:22:52', NULL, 0.00, 'started'),
(290, 247, 18, '2025-11-11 19:09:47', '2025-11-11 19:16:43', 10.00, 'completed'),
(291, 241, 18, '2025-11-11 19:29:42', NULL, 0.00, 'started'),
(292, 242, 18, '2025-11-11 19:40:24', NULL, 0.00, 'started');

-- --------------------------------------------------------

--
-- Table structure for table `sub_topics`
--

CREATE TABLE `sub_topics` (
  `sub_topic_id` int NOT NULL,
  `topic_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `added_by` int DEFAULT NULL,
  `by_admin` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sub_topics`
--

INSERT INTO `sub_topics` (`sub_topic_id`, `topic_id`, `title`, `description`, `added_by`, `by_admin`, `created_at`, `updated_at`) VALUES
(1, 2, 'list', 'fhk', 1, 0, '2025-09-03 10:02:08', '2025-09-03 10:02:08'),
(2, 3, 'list', 'hi hi', 24, 0, '2025-09-05 15:46:15', '2025-09-05 15:46:15'),
(3, 4, 'test', 'its a test subtopic', 23, 0, '2025-09-07 04:17:36', '2025-09-07 04:17:36'),
(4, 5, 'test', 'test', 124, 0, '2025-09-07 04:26:32', '2025-09-07 04:26:32'),
(5, 8, '`', '\'', 31, 0, '2025-09-07 06:26:43', '2025-09-07 06:26:43'),
(6, 9, 'Variables', 'Variables in python', 33, 0, '2025-09-24 05:40:35', '2025-09-24 05:40:35'),
(7, 10, 'Simple questions', 'test', 14, 0, '2025-09-24 09:22:07', '2025-09-24 09:22:07'),
(8, 11, '.NET', 'Dot Net framework', 12, 0, '2025-10-04 09:12:59', '2025-10-04 09:12:59'),
(9, 12, 'VARIABLES', 'OIUYTREW', 33, 0, '2025-10-10 09:09:20', '2025-10-10 09:09:20'),
(10, 12, 'VARIABLES', 'OIUYTREW', 33, 0, '2025-10-10 09:09:21', '2025-10-10 09:09:21'),
(11, 13, 'ARRAY IN C', 'ARRAY IN C', 27, 0, '2025-10-31 06:31:09', '2025-10-31 06:31:09'),
(12, 14, 'APTITUDE QUESTIONS', 'its questions', 23, 0, '2025-11-10 06:58:53', '2025-11-11 10:06:50');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `test_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `subject` varchar(100) DEFAULT NULL,
  `added_by` int NOT NULL,
  `topic_id` int NOT NULL,
  `sub_topic_id` int NOT NULL,
  `num_questions` int DEFAULT '0',
  `department_id` int NOT NULL,
  `year` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time_slot` time DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`test_id`, `title`, `description`, `subject`, `added_by`, `topic_id`, `sub_topic_id`, `num_questions`, `department_id`, `year`, `date`, `time_slot`, `duration_minutes`, `created_at`, `is_active`) VALUES
(1, 'hrrr', 'sher', 'hrhr', 24, 3, 2, 12, 6, '4', '2025-09-05', '00:00:00', 23, '2025-09-05 16:26:55', 1),
(2, 'ghw', 'wfg', '2w', 24, 3, 2, 12, 6, '4', '2025-09-05', '00:00:00', 12, '2025-09-05 16:28:09', 1),
(3, 'new', 'new one', 'new', 24, 3, 2, 8, 6, '1', '2025-09-05', '00:00:00', 8, '2025-09-05 16:33:19', 1),
(4, 'new', 'neq on', 'new', 24, 3, 2, 9, 1, '1', '2025-09-05', '00:00:00', 80, '2025-09-05 16:37:23', 1),
(5, 'new', 'neq on', 'new', 24, 3, 2, 9, 1, '1', '2025-09-05', '00:00:00', 80, '2025-09-05 17:15:56', 1),
(6, 'test', 'its a test', 'test', 23, 4, 3, 10, 1, '4', '2025-09-07', '00:00:00', 10, '2025-09-07 04:20:50', 0),
(7, 'test', 'test', 'test', 124, 5, 4, 10, 1, '4', '2025-09-07', '00:00:00', 10, '2025-09-07 04:27:20', 1),
(8, 'test', 'test', 'test', 23, 4, 3, 10, 1, '4', '2025-09-07', '00:00:00', 10, '2025-09-07 04:32:52', 1),
(9, '21dasfs1131`/.;\';0p09=0-=-*(#%$@', '', '345dfgsd', 31, 8, 5, 2147483647, 2, '1', '2025-09-07', '00:00:00', 2147483647, '2025-09-07 06:30:21', 1),
(10, 'Test for Sandhosh', 'Sample test', 'Python', 33, 9, 6, 5, 6, '4', '2025-09-24', '00:00:00', 30, '2025-09-24 05:47:31', 1),
(11, 'Python basic', 'Test for python', 'Python', 14, 10, 7, 15, 7, '4', '2025-09-24', '00:00:00', 30, '2025-09-24 09:25:17', 1),
(12, 'Testing', 'Testing', 'test', 33, 9, 6, 10, 7, '4', '2025-09-27', '00:00:00', 10, '2025-09-27 06:42:32', 1),
(13, 'trew', 'trrewsew', 'test', 33, 9, 6, 10, 7, '4', '2025-09-27', '00:00:00', 10, '2025-09-27 07:00:18', 1),
(14, 'Mock Interview Test', 'Mock Interview Test for .Net', 'C#', 12, 11, 8, 29, 1, '4', '2025-10-04', '00:00:00', 30, '2025-10-04 09:15:06', 1),
(15, 'TITLE', 'TESTING', 'PYTHON', 33, 12, 9, 2, 1, '4', '2025-10-10', '00:00:00', 5, '2025-10-10 09:12:15', 1),
(16, 'Programming in C', 'Its Programming Test', 'Programming in C', 27, 13, 11, 5, 7, '1', '2025-10-31', '00:00:00', 20, '2025-10-31 06:50:40', 1),
(17, 'Technical Ability – Aptitude Basics', 'This test covers 20 aptitude-based questions from topics including Percentages, Ratios, Time & Work, Averages, Simple and Compound Interest, Probability, Permutation–Combination, Pipes & Cisterns, and Boats & Streams. Designed to assess quantitative reasoning and analytical skills for interview and placement preparation.', 'APTITUDE', 27, 14, 12, 10, 7, '4', '2025-11-10', '00:00:00', 100, '2025-11-10 07:03:01', 1),
(18, 'APTITUDE QUESTIONS', 'Its Aptitude Questions', 'Aptitude Questions', 23, 14, 12, 10, 1, '1', '2025-11-11', '00:00:00', 20, '2025-11-11 10:07:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `test_questions`
--

CREATE TABLE `test_questions` (
  `test_question_id` int NOT NULL,
  `test_id` int NOT NULL,
  `question_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `test_questions`
--

INSERT INTO `test_questions` (`test_question_id`, `test_id`, `question_id`, `created_at`) VALUES
(1, 5, 11, '2025-09-05 17:15:56'),
(2, 5, 5, '2025-09-05 17:15:56'),
(3, 5, 9, '2025-09-05 17:15:56'),
(4, 5, 16, '2025-09-05 17:15:56'),
(5, 5, 3, '2025-09-05 17:15:56'),
(6, 5, 19, '2025-09-05 17:15:56'),
(7, 5, 15, '2025-09-05 17:15:56'),
(8, 5, 6, '2025-09-05 17:15:56'),
(9, 5, 4, '2025-09-05 17:15:56'),
(10, 9, 24, '2025-09-07 06:30:21'),
(11, 9, 23, '2025-09-07 06:30:21'),
(12, 9, 22, '2025-09-07 06:30:21'),
(13, 9, 21, '2025-09-07 06:30:21'),
(14, 10, 27, '2025-09-24 05:47:31'),
(15, 10, 29, '2025-09-24 05:47:31'),
(16, 10, 31, '2025-09-24 05:47:31'),
(17, 10, 26, '2025-09-24 05:47:31'),
(18, 10, 33, '2025-09-24 05:47:31'),
(19, 11, 34, '2025-09-24 09:25:17'),
(20, 11, 1, '2025-09-24 09:25:17'),
(21, 11, 13, '2025-09-24 09:25:17'),
(22, 11, 15, '2025-09-24 09:25:17'),
(23, 11, 24, '2025-09-24 09:25:17'),
(24, 11, 25, '2025-09-24 09:25:17'),
(25, 11, 20, '2025-09-24 09:25:17'),
(26, 11, 19, '2025-09-24 09:25:17'),
(27, 11, 30, '2025-09-24 09:25:17'),
(28, 11, 3, '2025-09-24 09:25:17'),
(29, 11, 14, '2025-09-24 09:25:17'),
(30, 11, 7, '2025-09-24 09:25:17'),
(31, 11, 18, '2025-09-24 09:25:17'),
(32, 11, 2, '2025-09-24 09:25:17'),
(33, 11, 11, '2025-09-24 09:25:17'),
(34, 12, 32, '2025-09-27 06:42:32'),
(35, 12, 8, '2025-09-27 06:42:32'),
(36, 12, 10, '2025-09-27 06:42:32'),
(37, 12, 22, '2025-09-27 06:42:32'),
(38, 12, 33, '2025-09-27 06:42:32'),
(39, 12, 24, '2025-09-27 06:42:32'),
(40, 12, 29, '2025-09-27 06:42:32'),
(41, 12, 27, '2025-09-27 06:42:32'),
(42, 12, 5, '2025-09-27 06:42:32'),
(43, 12, 26, '2025-09-27 06:42:32'),
(44, 13, 9, '2025-09-27 07:00:18'),
(45, 13, 31, '2025-09-27 07:00:18'),
(46, 13, 23, '2025-09-27 07:00:18'),
(47, 13, 33, '2025-09-27 07:00:18'),
(48, 13, 24, '2025-09-27 07:00:18'),
(49, 13, 19, '2025-09-27 07:00:18'),
(50, 13, 22, '2025-09-27 07:00:18'),
(51, 13, 2, '2025-09-27 07:00:18'),
(52, 13, 20, '2025-09-27 07:00:18'),
(53, 13, 36, '2025-09-27 07:00:18'),
(54, 14, 43, '2025-10-04 09:15:06'),
(55, 14, 63, '2025-10-04 09:15:06'),
(56, 14, 57, '2025-10-04 09:15:06'),
(57, 14, 50, '2025-10-04 09:15:06'),
(58, 14, 61, '2025-10-04 09:15:06'),
(59, 14, 56, '2025-10-04 09:15:06'),
(60, 14, 52, '2025-10-04 09:15:06'),
(61, 14, 60, '2025-10-04 09:15:06'),
(62, 14, 46, '2025-10-04 09:15:06'),
(63, 14, 67, '2025-10-04 09:15:06'),
(64, 14, 47, '2025-10-04 09:15:06'),
(65, 14, 45, '2025-10-04 09:15:06'),
(66, 14, 62, '2025-10-04 09:15:06'),
(67, 14, 40, '2025-10-04 09:15:06'),
(68, 14, 58, '2025-10-04 09:15:06'),
(69, 14, 55, '2025-10-04 09:15:06'),
(70, 14, 39, '2025-10-04 09:15:06'),
(71, 14, 42, '2025-10-04 09:15:06'),
(72, 14, 66, '2025-10-04 09:15:06'),
(73, 14, 53, '2025-10-04 09:15:06'),
(74, 14, 64, '2025-10-04 09:15:06'),
(75, 14, 59, '2025-10-04 09:15:06'),
(76, 14, 49, '2025-10-04 09:15:06'),
(77, 14, 65, '2025-10-04 09:15:06'),
(78, 14, 41, '2025-10-04 09:15:06'),
(79, 14, 44, '2025-10-04 09:15:06'),
(80, 14, 51, '2025-10-04 09:15:06'),
(81, 14, 54, '2025-10-04 09:15:06'),
(82, 14, 48, '2025-10-04 09:15:06'),
(83, 15, 69, '2025-10-10 09:12:15'),
(84, 15, 70, '2025-10-10 09:12:15'),
(85, 16, 76, '2025-10-31 06:50:40'),
(86, 16, 77, '2025-10-31 06:50:40'),
(87, 16, 81, '2025-10-31 06:50:40'),
(88, 16, 72, '2025-10-31 06:50:40'),
(89, 16, 74, '2025-10-31 06:50:40'),
(90, 17, 101, '2025-11-10 07:03:01'),
(91, 17, 83, '2025-11-10 07:03:01'),
(92, 17, 87, '2025-11-10 07:03:01'),
(93, 17, 88, '2025-11-10 07:03:01'),
(94, 17, 94, '2025-11-10 07:03:01'),
(95, 17, 93, '2025-11-10 07:03:01'),
(96, 17, 95, '2025-11-10 07:03:01'),
(97, 17, 92, '2025-11-10 07:03:01'),
(98, 17, 97, '2025-11-10 07:03:01'),
(99, 17, 98, '2025-11-10 07:03:01'),
(100, 18, 84, '2025-11-11 10:07:40'),
(101, 18, 91, '2025-11-11 10:07:40'),
(102, 18, 85, '2025-11-11 10:07:40'),
(103, 18, 92, '2025-11-11 10:07:40'),
(104, 18, 94, '2025-11-11 10:07:40'),
(105, 18, 95, '2025-11-11 10:07:40'),
(106, 18, 87, '2025-11-11 10:07:40'),
(107, 18, 82, '2025-11-11 10:07:40'),
(108, 18, 98, '2025-11-11 10:07:40'),
(109, 18, 86, '2025-11-11 10:07:40');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `added_by` int DEFAULT NULL,
  `by_admin` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `title`, `description`, `added_by`, `by_admin`, `created_at`, `updated_at`) VALUES
(1, 'Python', 'aaaa', 2, 0, '2025-09-03 09:57:24', '2025-09-03 09:57:24'),
(2, 'java', 'sdfghjkl;', 1, 0, '2025-09-03 09:57:26', '2025-09-03 09:57:26'),
(3, 'data science', 'hi', 24, 0, '2025-09-05 15:46:05', '2025-09-05 15:46:05'),
(4, 'test', 'its a test topic', 23, 0, '2025-09-07 04:16:33', '2025-09-07 04:16:33'),
(5, 'test', 'test', 124, 0, '2025-09-07 04:26:20', '2025-09-07 04:26:20'),
(6, 'Python', 'Python question unit wise', 31, 0, '2025-09-07 06:08:20', '2025-09-07 06:08:20'),
(7, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa0987r09238408023048324140.0.5045&^%&%^*((^&)&*(_)*(_DFSgsdj', '3as1df3\r\n213\r\n2sad3f1313adfs32dsa3f13', 31, 0, '2025-09-07 06:17:07', '2025-09-07 06:17:07'),
(8, '`', '`', 31, 0, '2025-09-07 06:24:36', '2025-09-07 06:24:36'),
(9, 'Python', 'Simple Python Questions', 33, 0, '2025-09-24 05:40:16', '2025-09-24 05:40:16'),
(10, 'Python', 'Test for python', 14, 0, '2025-09-24 09:21:46', '2025-09-24 09:21:46'),
(11, 'C Sharp ( C# )', 'C sharp', 12, 0, '2025-10-04 09:12:34', '2025-10-04 09:12:34'),
(12, 'PYTHON', 'VARIABLES', 33, 0, '2025-10-10 09:07:28', '2025-10-10 09:07:28'),
(13, 'C TEST ARRAY LOOP', 'array in C', 27, 0, '2025-10-31 06:30:26', '2025-10-31 06:30:26'),
(14, 'Aptitude  Questions', 'its test', 23, 0, '2025-11-10 06:58:18', '2025-11-11 10:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `roll_no` text COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `year` int NOT NULL,
  `role_id` int NOT NULL,
  `department_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `roll_no`, `name`, `email`, `password`, `year`, `role_id`, `department_id`, `created_at`, `updated_at`) VALUES
(9, 'NS20T40', 'VENKATALAKSHMI M', 'VENKATALAKSHMIMS@GMAIL.COM', '', 4, 2, 1, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(10, 'NS20T33', 'DEEPIGA K', 'DEEPIGA.KECE@GMAIL.COM', '', 4, 2, 1, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(11, 'NS20T37', 'GEERTHIGA G', 'GEERTHIGUBENDRAN@GMAIL.COM', '', 4, 2, 1, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(12, 'NS20T35', 'ABIRAMI KAYATHIRI S', 'ABIRAMIKAYATHIRI@GMAIL.COM', '$2y$10$mdikPhl9Gk8.Aie9B8e4Pe9l4xGq4vfdKPs/fLxzze2CQ3D4oiz5e', 4, 2, 1, '2025-09-05 14:52:15', '2025-10-04 09:11:17'),
(13, 'NS20T38', 'PAVITHRA M', 'PAVITHRAMANIBTECH@GMAIL.COM', '', 4, 2, 1, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(14, 'NS20T39', 'BHAVANI M', 'GMBHAVANI1990@GMAIL.COM', '$2y$10$rJ95EtGquYo5OUnIpQfpAOFYNxJlButIqrUPBAdF7Qa5R/0kWh5YG', 4, 2, 7, '2025-09-05 14:52:15', '2025-09-24 10:06:19'),
(15, 'CS4', 'UDHAYA KUMAR.R', '', '', 4, 2, 1, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(16, 'CS12', 'Dr.MATHALAI RAJ. J', '', '', 4, 2, 1, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(17, 'NS20T36', 'NIRANJANA.P', '', '', 4, 2, 1, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(18, 'NS2207T15', 'PRATHAP. C', 'c.prathap1985@gmail.com', '', 4, 2, 1, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(19, 'NS20T14', 'ARUL JOTHI.S', 's.aruljothi04@gmail.com', '', 4, 2, 1, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(20, 'NS20T34', 'KESAVAMOORTHY N', 'kesavamoorthyncse@gmail.com', '', 4, 2, 1, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(21, 'NS20T32', 'VINOTH KUMAR J', 'VELVINOJAGAN@GMAIL.COM', '', 4, 2, 1, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(22, 'CS10', 'VIGNESH.L.S', '', '$2y$10$Svm7w0chTse2rxSzSjghRe0NtBjbh31wU1D/CXD9KDlNVmltbm0LW', 4, 2, 6, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(23, 'NS20T29', 'ARCHANA R', 'emails4archana@gmail.com', '$2y$10$Ca/ptZaBrJFy86usovG0feELkXQb4Crk5v0jbyAEqCkJX7QLuQqGi', 4, 2, 1, '2025-09-05 14:52:15', '2025-11-11 10:05:18'),
(24, 'NS80T01', 'NAGAJOTHI P', 'NAGAJOTHI335@GMAIL.COM', '$2y$10$txOHUzCHgzZUkF8hIJdngOPSC/R6kZRiLvte39C1dU35Gpj1RClja', 4, 2, 6, '2025-09-05 14:52:15', '2025-09-24 10:07:12'),
(25, 'NS70T05', 'MAHALAKSHMI S', 'MAHALAKSHM92@GMAIL.COM', '', 4, 2, 7, '2025-09-05 14:52:15', '2025-09-24 10:06:19'),
(26, 'NS70T03', 'KEERTHANA G', 'keeru2293@gmail.com', '', 4, 2, 7, '2025-09-05 14:52:15', '2025-09-24 10:06:19'),
(27, 'NS70T04', 'SAI SUGANYA B', 'SAISUGANYAHP@GMAIL.COM', '$2y$10$BQTIaV7bvIovFsTvkaooROJvPG/xArd7NPYofb6kQ/rvOIejlJlLG', 4, 2, 7, '2025-09-05 14:52:15', '2025-10-31 06:28:31'),
(28, 'NS70T07', 'JASMINE JOSE P', 'JASMINEPERCY16@GMAIL.COM', '', 4, 2, 7, '2025-09-05 14:52:15', '2025-09-24 10:06:19'),
(29, 'NS20T25', 'VELKUMAR K', 'VELKUMARSKC@GMAIL.COM', '', 4, 2, 7, '2025-09-05 14:52:15', '2025-09-24 10:06:19'),
(30, 'NS70T02', 'KANIMOLI J', 'KANIMOLI.1695@GMAIL.COM', '', 4, 2, 7, '2025-09-05 14:52:15', '2025-09-24 10:06:19'),
(31, 'NS70T01', 'DR.M SATHYA', 'MSATHYA15@GMAIL.COM', '$2y$10$GoQ1rvfq/dqKbJknw7MPBexdTBp/Xc0FredbPum1u/QtSg9ltMEyW', 4, 2, 7, '2025-09-05 14:52:15', '2025-09-24 10:06:19'),
(32, '9210', 'Santhodh', 'santhosh@gmail.com', '$2y$10$4ZTY5ulUShkONm/Ig95l0OG4NrO.Lx/YpfYgEHGT56pxAJiJABghG', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 05:49:29'),
(33, '123', 'Vinoth kumar', 'vinoth@gmail.com', '$2y$10$vDS/Mqg8Kbzg94PxZXcwk.weuQA.roKGf0Q4qTXRYXtML2Vnl6rMu', 4, 2, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(34, '92101', 'Sachin', 'sachin@gmail.com', '', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(35, '92102', 'Sri Hari', 'srihari@gmail.com', '', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(36, '92103', 'Aaswin', 'aaswin@gmail.com', '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(37, '92104', 'Keerthana', 'keerthana@gmail.com', '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(38, '92105', 'archana', 'archana@gmail.com', '', 4, 2, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(39, '921022243001', 'AJAY M', NULL, '$2y$10$xngmq8Oog.94eJuZ3irI/.5A84KBSDNFuyAbwpPi3Bxlq38nTsg1m', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(40, '921022243002', 'AJAY S', NULL, '$2y$10$A/O6LJ71a2OZGOfRxIvP8OXztPaGR0kJyT0S5G9B9N.q9.JsLG.va', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(41, '921022243003', 'AKSHAYA K', NULL, '', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(42, '921022243004', 'BALA MAHALAKSHMI S', NULL, '', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(43, '921022243005', 'DHEIVASHRI M', NULL, '', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(44, '921022243008', 'ISHANI P', NULL, '', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(45, '921022243009', 'JAYA GOKUL M', NULL, '$2y$10$bqs98fVbsBeMkGrEPQakbu4G9mtIF82Au9PfV0TlqgAXKbx7Yvvya', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(46, '921022243010', 'KARAN S', NULL, '$2y$10$lX3l5nU7ZFPOsLWHOy5Ga.a/4Tfy0drx0X1H02cW1U84Km/3yxS3m', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(47, '921022243011', 'KEERTHANA T', NULL, '', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(48, '921022243012', 'NAVEEN KUMAR S', NULL, '$2y$10$3s6ThXw6RtzBs9NcZP41Xe1kqxpZgl9fMQbrp/FI/kS2oS2cmdvcC', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(49, '921022243013', 'NITHEESH PATRICK P', NULL, '', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(50, '921022243014', 'PARI VIGNESH D S', NULL, '$2y$10$lf1jsjybI2laMbBzVlUCUezL42GuKwiRTsDhHoqx6LccDdV4X/iMy', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(51, '921022243015', 'PRANAV S', NULL, '', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(52, '921022243016', 'RAJAVARSHINI C', NULL, '$2y$10$nxbwuEa1jk0TzivonjyGxu0lvWZLsVbdzvxN6qaFHAVXNJZxFwu.W', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(53, '921022243018', 'SHAFANA IRFATH N', NULL, '$2y$10$NcSqynS7.oAq.b.5fMtJluvrTiFOHSm.X44438Z9eazbQfSTnSdOK', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(54, '921022243019', 'SHAFEEK MURATH S', NULL, '$2y$10$afgAofw4j97V/PnbQtPs0OUuAXUqKc8aXVCkYL1dcnW1c3UjNEaiO', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(55, '921022243020', 'SHOBIKA SHREE N', NULL, '$2y$10$LPHQYYFEaA/Yg8UQFFs7fOd1No7q5H3BUueQWznjJ.Dpq6O1NHUkC', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(56, '921022243021', 'SHRI HARINI S', NULL, '$2y$10$CcTIlhYJTAAqOXTgruhFL.Tc4wOD/5oG/8uBEtkfbTqvjTQMww6a.', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(57, '921022243022', 'SRIDEVI B', NULL, '$2y$10$yhyIjmFtdv0equT.Srd6a.cbnYMiq1XdoYLMyc3Uj961fRhjrJxJG', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(58, '921022243023', 'VISHWAROOBINI N', NULL, '$2y$10$wFnl0LKo/Y5OreUpr7bLSenHJwse80igLK9nKZOG7D7UUHGQRY8gS', 4, 1, 6, '2025-09-05 14:59:26', '2025-09-27 06:45:33'),
(59, '921022205001', 'AASWIN J S', NULL, '$2y$10$hjx9HUD3hiUAppbanqxlxOVChp8fkfKoVAvx6XgrUHX9ORMU209xe', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 12:15:55'),
(60, '921022205002', 'ABI GAYATHRI P', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:03:44'),
(61, '921022205003', 'ABINAYA P', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:03:44'),
(62, '921022205005', 'GOWSIK P', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:03:44'),
(63, '921022205006', 'MOHAMED IRFAN SHEIK K', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:03:44'),
(64, '921022205007', 'NAAFIYA SHIRIN A', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-09-24 10:06:19'),
(65, '921022205008', 'NAGAJOTHI M', NULL, '$2y$10$6V3ssQTgAGGurLrkUAbf7uUMVV1ONWgtrkNy31SS.2iXKqGf3CO0y', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:06:46'),
(66, '921022205009', 'NANDHINI S', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:03:44'),
(67, '921022205010', 'NATHIYA P', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:03:44'),
(68, '921022205011', 'NAVEEN BHARATHI B', NULL, '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-09-05 14:59:26', '2025-11-11 10:08:33'),
(69, '921022205012', 'NIHILAA K', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:03:44'),
(70, '921022205013', 'PARAMESHWAR N S', NULL, '$2y$10$R667ADx/15ASVmX/5gpnMeYrnxkTCwkgoAZimK/JxjQfjJDJebS7y', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:12:47'),
(71, '921022205014', 'PRAVIN K', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:03:44'),
(72, '921022205015', 'PREETHI V', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:03:44'),
(73, '921022205016', 'RAMYA PRIYA J', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-09-24 10:06:19'),
(74, '921022205017', 'RANA SUSMITHA R', NULL, '$2y$10$/a9OWMAtuqfRe5gULbEfQe9MCkh2LJHxifsbqpRIHsJk6HDLUrkpK', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 13:39:38'),
(75, '921022205018', 'SARVAJI M', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-09-24 10:06:19'),
(76, '921022205019', 'SATHYA SEELAN M', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-09-24 10:06:19'),
(77, '921022205020', 'SIVASRI V', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:03:44'),
(78, '921022205021', 'SRIHARI PRASATH A', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-09-24 10:06:19'),
(79, '921022205022', 'SURYAPRAKASH A', NULL, '$2y$10$UzfZsCz0sl66s5/UzZmDL.rLB4KF9A6vCzZRFsmqi.tMOD6J5ZgwO', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:07:31'),
(80, '921022205023', 'SWATHI P', NULL, '$2y$10$bHdquaGfR90yB3jIt89nfe8E8pfGPycCF4NBb0nbvLR0Q1TCrWtFG', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 13:49:44'),
(81, '921022205024', 'VIGNESWAR S', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 09:03:44'),
(82, '921022205025', 'YAMINI S', NULL, '$2y$10$eKZ9xrjwq2w9UjhR0EXwquc3ZaXrTNFJoBhrMzi4Bw2Ar88jr4klu', 4, 1, 7, '2025-09-05 14:59:26', '2025-11-10 16:22:22'),
(83, '921022205026', 'YOHITHKUMAR R', NULL, '', 4, 1, 7, '2025-09-05 14:59:26', '2025-09-24 10:06:19'),
(84, '921022104001', 'AARTHI S', NULL, '$2y$10$7hC0cFjKiCaAaGbkBm9LL.tsUHPW5ZEF0KLd2X9oJU2BqpdMASSje', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:34'),
(85, '921022104002', 'ABARNA A', NULL, '$2y$10$TWuuGZmJRvu0OkwJ9Vt2p.OW5ekv0imtA9a/.oR8Peexw.HwDs2DW', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:10:08'),
(86, '921022104003', 'AKILAN A', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(87, '921022104004', 'AKSHAYA N S', NULL, '$2y$10$qymy9AhW4RS3wLzj3aKG/uy4F4ctPyaTST99vuxzp.dTvDBPy36Oy', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:31'),
(88, '921022104005', 'ANANDHITHA GAYATHIRI A', NULL, '$2y$10$hGSKjw3F8iNmpWQSrADrfuqq7/x8cvxaheWjFQjTkUV2OjZZa9T4i', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:10:24'),
(89, '921022104006', 'ANKAYARKANNI M', NULL, '$2y$10$vqzS8je3ljwtUsWPq2w74ehJ6cWIoA1QaMwn7vOkk5Z9TuYh5XxyO', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:54'),
(90, '921022104007', 'ARCHANA A', NULL, '$2y$10$uKRmqNe6Mzcq1.ITx91PPeTzGw5mHcF4QnTLPRiYeiNA1ZLW20nPC', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:38'),
(91, '921022104008', 'BHARATH SURYA M', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(92, '921022104009', 'CHANDISH S', NULL, '$2y$10$hvqvfFfDUTjeVntrIaaR3.m8XllgdRXDQ40xdMGxil/8ytzfp/B.m', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:15:57'),
(93, '921022104010', 'DHANUSH D', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(94, '921022104011', 'FARHANA BANU K', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(95, '921022104012', 'FEMILA M', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(96, '921022104013', 'GOKULNATH B', NULL, '$2y$10$xSrx6zWURimUPbfwh37CxefFooWVezFGpKmKc/eMdnQ7Lb3.tp602', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:22:00'),
(97, '921022104014', 'GOWRI M', NULL, '$2y$10$7I5mgyN5aC/Vk4sDiaDRp.CnA.klg6P2hXqv6KxAer82ntTPb0eiS', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:32'),
(98, '921022104015', 'HARINI G', NULL, '$2y$10$tnFSfIgwVYHIHRD4mWv42./2Om80KMMcSd9KoB7oyG2.rz/rNdj92', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:32'),
(99, '921022104016', 'HARINI J', NULL, '$2y$10$ZuTGql1PhL2UIbmzVWJmHueJYLqPSUMfYSA3nu7dqrsasvvAYU3hm', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:08:39'),
(100, '921022104017', 'JEYASRI C', NULL, '$2y$10$QMa83NWlfhOmbUCBKVf76.ronNNWHGIVlaeVbaLiG5e4hDVT.2.W2', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:10:13'),
(101, '921022104018', 'KALA DEVI S', NULL, '$2y$10$SnpEz8DoZ4oxtUgx/Pl3suCJDs3ktT5ZYClVf55NHy5Zm.zVnmhVC', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:13'),
(102, '921022104019', 'KALAI SELVI M', NULL, '$2y$10$s9PREUykyDu1dfURarPzCuRyLJaujt2SaxcLntDAuGy7ddwmyCdN6', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:10:10'),
(103, '921022104020', 'KARUNYA JOTHIKA S', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(104, '921022104021', 'KAVIYASHREE B', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(105, '921022104022', 'KIRUTHIKA G (07.09.2004)', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(106, '921022104023', 'KIRUTHIKA M (18.11.2004)', NULL, '$2y$10$D9Av5QPMvlWTVzhnE2h4/OLx77KBGsPKkuoah0X5y9aYh3XvQNBda', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:10:06'),
(107, '921022104024', 'KUZHALI E', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(108, '921022104025', 'LALITHAMBIHAI R G', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(109, '921022104026', 'MADHUBALA S', NULL, '$2y$10$YrDattIrONEdYEQpJp/6nuE69.7m9EiNYBdU/mtYC1oozY8yWXxMa', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:10:43'),
(110, '921022104027', 'MAHMOOD SHAFI K', NULL, '$2y$10$3ADxYZj72WhXBuh2jGoMWe8d5VZZKo4Q7VOb7yZfyPf0nS5V6eD7m', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:48'),
(111, '921022104028', 'MATHAN M', NULL, '$2y$10$vykg5lK4xnSJfPtHX1fyOu08icRnNyFv2HrYrVegcjRzcxLoFgrDq', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:07:46'),
(112, '921022104029', 'MIRUTHYUNJAY J A', NULL, '$2y$10$gqIhKj.Nhx73fmUIE2tlXue2MQ3MHJVTfabsITOngw4DnJKBSZip2', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:11:07'),
(113, '921022104030', 'MONISHA C', NULL, '$2y$10$.KxajdGHc5KbkNmVTS4HkOUTc6mSHoi7hRNcFOUl1vtAUjPdU7Jqa', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:08:53'),
(114, '921022104031', 'NANTHIDHA S', NULL, '$2y$10$E/.RxRiQUaZNSSXT91i/2O7F/Jvh9aBmtXnuQVs6mqTEfLRAhk3YC', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:24'),
(115, '921022104032', 'NITHISH V', NULL, '$2y$10$VdAgOhJf09QUwEyVfRZKD.vcRbRCKtUsgnh/ToIKAVe.AVH1OFKy2', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:27'),
(116, '921022104033', 'JOSHIKA', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(117, '921022104034', 'POOJA T', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(118, '921022104035', 'PRIYANKA M', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(119, '921022104036', 'PUNITHA B', NULL, '$2y$10$8Nofv8yecllAw0VeoMoMFu1rjjVpifB.P4HVF3CQGLX9BO1NABaU2', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:57'),
(120, '921022104037', 'RAMSANJEEV R', NULL, '$2y$10$bLzF1wRoAUWgnQvaweGJlu/YxZ31mlZiSyGwDvv2G.WpGKq/m4myW', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:19:29'),
(121, '921022104038', 'RAVINTHAR A', NULL, '$2y$10$Rhf4X8ATJlqpDc7rgSoiCuyh0qJ3/p7B9bL3Y5jQay6Tinuz8csYO', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:15'),
(122, '921022104039', 'RESHMA SHREE L V', NULL, '$2y$10$oesSxcloCjtT7g9zmIeZTOEM/6lftEFv6ihhXI1a2qMyqTzIiwlvy', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:08:26'),
(123, '921022104040', 'RITHISH V', NULL, '$2y$10$20zSqpNlo9bz.3ZjrrwxLuj8rlZqZibXg1D8PwGdXNBJpRnzTC99u', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:10:14'),
(124, '921022104041', 'SACHITHANANDAN S', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 09:15:45'),
(125, '921022104042', 'SHIVANIHA J', NULL, '$2y$10$TM1PwHE9W2IDsEdVup193OGw9O.oNYfHNzaAhI4L0X6uXoSRbF5Im', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:16:03'),
(126, '921022104043', 'SIMRITHA SRI V', NULL, '$2y$10$UxR5r2g4glM1YAxYMN4YBeDjuVHeY4.Mz.C.QyBGeP9Agt4iGcOk2', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:27:01'),
(127, '921022104044', 'SIVA PANDI V', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(128, '921022104045', 'SONIYA N', NULL, '$2y$10$1LvYDfp.hNyGiIzmNf8Xpug7mQQyMtEE7A/AsTsSewQvGwWBdj80m', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:33'),
(129, '921022104046', 'SRI NATHI S', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(130, '921022104047', 'SRISAKTHI S', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(131, '921022104048', 'SUBIKSHA M', NULL, '$2y$10$thu0hHe.gRU7Xb8eCpoqQeQ2sLl1YP5zye3dCoxr28ErtqPS9/hy.', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:01'),
(132, '921022104049', 'SUBIKSHAA S', NULL, '$2y$10$FZq0wF7X6aTkRlQj1pYB2.f/qLgFc7hmqPhMRIx1.EnCD4u0Xmm.K', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:08:47'),
(133, '921022104050', 'SUJITHRA V', NULL, '$2y$10$o3zSmbUul1exfRWtkTY.n.vHtdjw/.gQCOIYVha9us0Ms34s0oMUS', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:40'),
(134, '921022104051', 'SURUTHI PRATHAP S', NULL, '$2y$10$1X82XoowimMakl.GZ3hoPeMk8DsyRJkdSLSj82i.gVaBiOViyQ.ue', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:10:05'),
(135, '921022104052', 'SUSMITHA S', NULL, '$2y$10$srMab9T48e9g3SQqjPGHX.aKgGr0gjmrVBaUwmMG/UqrHYtx8tb3e', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:25:25'),
(136, '921022104053', 'SWATHI K', NULL, '$2y$10$yYP5rXB7RcYl2bc6KJeyu.aP1i1WyPRGFO6dXieISfx83GRx.G6.O', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:45'),
(137, '921022104054', 'THAVASAKTHI G', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(138, '921022104055', 'VARSHINI K', NULL, '$2y$10$LCsz9a.7fJ.shItJ5eDGZ.FAKHWLVwasea2qL532v4olwhlFwHvh2', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:28'),
(139, '921022104056', 'VIJAY AKASH M', NULL, '$2y$10$CINukFYzV9Rat1iXW5JPVOePYiiVeNEyS1cYUFIeD0hlqIc0AdTGK', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:15:14'),
(140, '921022104057', 'VIJITHRA V', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(141, '921022104058', 'VINYAA SREE P G', NULL, '$2y$10$uTGdILbOVklXCTSfO0WbdOu9Lui3c.F3cXzB7h.23IuwzPDqqZJqi', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:09:16'),
(142, '921022104059', 'YOGESHWARAN M', NULL, '$2y$10$vNQn5PCgheIN5P37LAol/ebk5H4KPyR4.AfjNpykFW9wR8WtB5GWO', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:19:19'),
(143, '921022104060', 'YUGESH KUMAR A', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(144, '921022104701', 'MOHAMED JAMEES K', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(145, '921022104702', 'SAKTHI PANDEESWARI S', NULL, '', 4, 1, 1, '2025-09-05 14:59:26', '2025-09-24 10:07:12'),
(146, '921022104703', 'UMA MAHESWARI B', NULL, '$2y$10$lffYc4zSKwzQ1dkhlChbNOc3.Yn3WGpuMaKSxxBNdcTAXWnGDXnJa', 4, 1, 1, '2025-09-05 14:59:26', '2025-10-04 10:18:22'),
(147, '921025205001', 'ABARNA M', NULL, '$2y$10$369wLjrCIbwmKAa/x5LkGOoh433sxzbLOcyzSbgV6OOlNz/PbujL2', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 14:46:22'),
(148, '921025205002', 'ABIRAMI R', NULL, '$2y$10$AA3U.0L5adh7UOrmr.i07uV4eh7KE4eFreYlAXUs7NQo1ioBdkgaC', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 13:52:45'),
(149, '921025205003', 'AISHWARYA LAKSHMI S', NULL, '$2y$10$S24AeFJMFbBwIH0BgHFB6uqbs.A1C39u3pMYiTFeJZazAEVaCVVv.', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 12:30:51'),
(150, '921025205004', 'AKSHAYA S', NULL, '', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 09:33:08'),
(151, '921025205005', 'ARAVINDHAN K', NULL, '', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 09:33:08'),
(152, '921025205006', 'ARCHANA P', NULL, '', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 09:33:08'),
(153, '921025205007', 'BHUVANA SRI G', NULL, '$2y$10$nSA/zHoNfohe3AvPyB2.1uEvJ7vKDrfgAlQn59fJCVes5HJvZ68YW', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-04 15:59:58'),
(154, '921025205008', 'DEENA P', NULL, '$2y$10$N/CpZ9wCr6.r/UjVpwm10eg7LmpAWcGr/v1cbS4DhznEvqMxUXjRu', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 13:03:23'),
(155, '921025205009', 'DHANALAKSHMI R', NULL, '$2y$10$B15YpLxuj/zqxcJaJanxl.2uSmFF40rrYqWxplimiPV5wv77.FH6O', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:40:54'),
(156, '921025205010', 'DHARSHINI M', NULL, '$2y$10$BR1ErWmGn7hBoFAaJvG8Y.gV8g3NJXVD18DR4qxKvYeGIb9NSQ/kO', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-04 14:51:59'),
(157, '921025205011', 'DIVYASRI S', NULL, '$2y$10$svcign6lpabQIZfAdRSVwuxQy8mpT1NRH.4LjBcDVRwWgrK4UJp/q', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-05 13:47:52'),
(158, '921025205012', 'ELAKKIYA M', NULL, '$2y$10$dJj3K9WsrKXxO3gjIuIZUOzmrzKlt73rhE02.XyaGLmlfFpBh1F6u', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 12:27:41'),
(159, '921025205013', 'GOBIKA SRI S', NULL, '$2y$10$isyiUwU35i0GDEskfsqg3uW7ALnKndOFZrCjUgqch/cbqdmt66UqK', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-06 13:27:36'),
(160, '921025205014', 'GOWTHAM KUMAR M', NULL, '$2y$10$Fjo27dU1YAjvIpQLVQk4Ce5M14QRtioyrCabWctCGcT3dNlSbYln2', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-04 13:25:21'),
(161, '921025205015', 'GURU K', NULL, '$2y$10$VKvCkA8.EsY2C/d7sfO.OOXSzLPo15I5jZDHsC4KFjK/XepsbuYBa', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 12:48:55'),
(162, '921025205016', 'HARIPRIYA R', NULL, '$2y$10$1xau1/T/C2ccfX0evznZcej7Jp/jxd29tfUfwYcMJR5uvhXOIsHQO', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 07:37:55'),
(163, '921025205017', 'JANARTHANAN M', NULL, '$2y$10$QALq/fhK.S.UA02jgEmM4uhxS6IeZMlnvGV9Ak/kXVuB2PRVkMrwK', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:37:06'),
(164, '921025205018', 'JEYAKRISHNAN P', NULL, '$2y$10$cnsDsNVsAlL13ix/4l.rxeFDNa/II1NTdsyMP44s0e9os98KbGUui', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 02:10:57'),
(165, '921025205019', 'JEYSREE S', NULL, '', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 09:33:08'),
(166, '921025205020', 'KARTHIGA M', NULL, '$2y$10$aNX84RqMW.kcPtpP.qqy3uMct0OUkXwqhcPh7G2BeZfBJvGIESX6W', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 13:05:02'),
(167, '921025205021', 'KIRUTHIKA S', NULL, '$2y$10$EDU10zrkPq1F3U1Gi3k0m.SlyztHEIf..V8lcSlNF5hxsfgFHgvXu', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-04 13:34:28'),
(168, '921025205022', 'LAKXMAN HARI K M', NULL, '', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 09:33:08'),
(169, '921025205023', 'LOGASRI K', NULL, '$2y$10$lpzMMijCtXdyHYrsLRFt/..uTdzLg4NMBwwqkROP8gjjPL1/Nxjoy', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 13:04:49'),
(170, '921025205024', 'MAHALAKSHMI R', NULL, '$2y$10$0fLbrfRVXkOs3pC31sRUmOPvVDvwjpo7BGkb4EbxXVothcz3G0lqu', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:02:38'),
(171, '921025205025', 'MAHARAJAN K', NULL, '$2y$10$DBgH.kZ9yzvm/WRUCmDzrOo0KYRU3gNBDlQWqNoQ7FeWyoVs6aXPm', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 13:18:27'),
(172, '921025205026', 'MAHIMA GRACE G', NULL, '$2y$10$gEnMJS9jlBbxvNwGwH9Sx.bN19q8.8FYJQknvUOvBoSiBmGyx.6Ba', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 05:09:45'),
(173, '921025205027', 'MOHAMED IRFAN P', NULL, '$2y$10$Qd4u6dMVENWt5pdSP4k6E.EHt57VkYptOUGUyBfg/ZWskeE53oJii', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 16:14:17'),
(174, '921025205028', 'MOHAMED SYATH ARAFATH A', NULL, '', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 09:33:08'),
(175, '921025205029', 'MUTHU VETHA VARSHINI M', NULL, '$2y$10$0CMkrG9WXzCSmH3IXkWiAeRQ.4KP7028tuWfIOO0KcIPFU6mM3hk6', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-03 12:58:14'),
(176, '921025205030', 'NAFILA FATHIMA R', NULL, '$2y$10$FOIhl9Two6a1YTIeSrDMn.MwfeGPcCI9..jS5vwJaP/R1pDOVp1Hi', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 13:40:22'),
(177, '921025205031', 'NIROSHKUMAR R', NULL, '$2y$10$cp0H.fmsbDwuLVXKMHn7f.TVWB80TSCLCAeoLcQAymHehLdoVJZEy', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:54:38'),
(178, '921025205032', 'NISHANTHINI R', NULL, '$2y$10$MTbeRmOdi5QanoP0IzDE7.9EpFvD0W9/.LGlZ49/jLBQL7NYNZXyW', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 02:34:45'),
(179, '921025205033', 'PAVITHRA R', NULL, '$2y$10$MMi4w1F0qbIzL5KY7IWNp.gCIUbwxRQ7kvI1KXDtxulxcgcDCEZcW', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 13:43:49'),
(180, '921025205034', 'PRATHIBHA SHIVARANJANI P', NULL, '$2y$10$/01lCphQMaiPW124aaH7EebQu5qtS/DD0OVp7jnfUcUuSzXmDHuUm', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 13:47:00'),
(181, '921025205035', 'PRATHISHA ARASI S', NULL, '$2y$10$XTlmH8r.SNNlGlpqv.nEU.QTlpJUa5OodgIpntlESAdUBtfus1FkW', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:25:55'),
(182, '921025205036', 'PRAVEENA M', NULL, '$2y$10$P.N3e/F3kp1cQfp4bFWM4OV1wGGhzEkozj.g6eJbsPps7RQlAr1IC', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:51:51'),
(183, '921025205037', 'PREETHA M', NULL, '$2y$10$pMnZSZH4v8AvRyMUq11s.uGVfFVw3xTWbMbprh6H/ltgQOlpT1mvy', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:36:25'),
(184, '921025205038', 'PRIYADHARSHINI M', NULL, '$2y$10$Is9NrpK5/jnhvTMYSmOJKO3dhH2Apd6Kr6ItmkdYknb1g.EXKNsp6', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-05 12:42:15'),
(185, '921025205039', 'RAJANESWARAN N', NULL, '$2y$10$m.334n7KthXn3ehAEOeDSOTQ9Ae7YbhfH2/OiVh9ZwYuGQS0t0BuW', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-03 12:27:25'),
(186, '921025205040', 'RAJIYA PRIYA K', NULL, '$2y$10$jDkTrVBaKfK0RO6H2Mgwt.bx8AEie9rlSg53CwFX1/7XI6pgHHsX.', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-04 16:05:31'),
(187, '921025205041', 'RENUGA K', NULL, '$2y$10$CSGbvAaKgCi43p9PN79dLu3lbLa8s2sA0qpAplQZyGTTNVmTnEeAi', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 15:25:29'),
(188, '921025205042', 'RINISHA M', NULL, '$2y$10$DRl13J8Gc1BGT1e3riljS.qYhftFnluJ.1kMg0NLvCvT78GDqcXaS', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 13:18:32'),
(189, '921025205043', 'ROHITH BALAJ IM', NULL, '', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 09:33:08'),
(190, '921025205044', 'ROSHINI M', NULL, '', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 09:33:08'),
(191, '921025205045', 'SABANA BANU K', NULL, '$2y$10$v8SSSrYbKeITMdh9xVw7R..jmHr4HszPzGMSQ8AB1JzNMiIzU7EN.', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 13:31:59'),
(192, '921025205046', 'SANJAY KUMAR B', NULL, '$2y$10$HyTxx78YGp2eukpvgXl4SecKuxDnJ690seBB7qjlqcRkztbK68cAW', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:24:56'),
(193, '921025205047', 'SANTHOSH P', NULL, '', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 09:33:08'),
(194, '921025205048', 'SARAVANA KUMAR A', NULL, '$2y$10$0FrBah45DX6RWsBfhl5rruk1wdQAUYPwvuUfOQI2tRhRZBc5J2W72', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 12:26:07'),
(195, '921025205049', 'SARUSHEELA G', NULL, '$2y$10$oxq7.3ScDyrLosiKP9t53uO9EDvs0xRLorSf17qJjh.JkUgvT3Xd6', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-04 00:58:56'),
(196, '921025205050', 'SHANMUGAVALLI K', NULL, '$2y$10$kZNZOsZF/c.iY5Xzgvy1WegLQqnIcgxLGXj3F0WTF/CPJV827vGfe', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 05:59:57'),
(197, '921025205051', 'SHARUNETHRA V', NULL, '$2y$10$sHqUIjnkkdZBX9e5MYJsfeuqdt32cJ0W9SIyMP69DgToGcZImKxQe', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 05:15:56'),
(198, '921025205052', 'SHIVANI B', NULL, '$2y$10$FAV8wLkn2iStbLbfgqKtTeOey23/7WgUj6pVL5JwiAji1we9hszIO', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:53:45'),
(199, '921025205053', 'SHOBA M', NULL, '$2y$10$Z.v1xPrh4MHTKvz2qb7h/.MLiy/DB2TNH3R4BjulOjkLEzewYeox6', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:25:17'),
(200, '921025205054', 'SUJITHRAM S', NULL, '$2y$10$qZJkm33YFAyrUE5aaY4kEe3NmpJHU2yUVsKNqsBFHrIoEqf.3y4mC', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:11:09'),
(201, '921025205055', 'SWETHA T', NULL, '', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 09:33:08'),
(202, '921025205056', 'THANISHA S', NULL, '$2y$10$RdzJMrQTXwQPThr.4Ru.fuHvlzaQFgrQ6650wpL5SxbS1tceulC9e', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-05 16:22:48'),
(203, '921025205057', 'THEJINI P', NULL, '$2y$10$/jevD12Se/OyGjaRo5KZb.8GoF0PXqB8mFhN0A9P.nIQISZatABc6', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 14:55:19'),
(204, '921025205058', 'VEERUJOTHI P', NULL, '$2y$10$Q1rBl3n.ZgKG6orEKxFEKOtbpePlx/u7wyqO97kjd97RytmOSmTzq', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-02 10:44:07'),
(205, '921025205059', 'VELMURUGAN J', NULL, '$2y$10$o0vu4pV4S.hYTWxcmQcO0eZ/KnTO4x4F.cj7lZviu9V3zWrNzVWDa', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 12:32:36'),
(206, '921025205060', 'YUGASHRI S', NULL, '$2y$10$Ei/E0mPP9llBlSYS0/9UbedZ4ckrDtfxCfN5o5HGbdckeyzAh.lIW', 1, 1, 7, '2025-11-01 09:33:08', '2025-11-01 13:32:10'),
(207, '921025103001', 'AFREEN FATHIMA M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:30:45'),
(208, '921025103002', 'ANITHA A', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(209, '921025103003', 'ARAVIND KUMAR T', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(210, '921025103004', 'ARO NIRANJAN S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(211, '921025103005', 'ATCHAYA S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(212, '921025103006', 'BOOMA P', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(213, '921025103007', 'DEEPIKA K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(214, '921025103008', 'DHANYA SHREE K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(215, '921025103009', 'ENIYA K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(216, '921025103010', 'GIRI S P', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(217, '921025103011', 'HARSHA M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(218, '921025103012', 'KAVIYA DHARSHINI K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(219, '921025103013', 'LOGESHWARI P', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(220, '921025103014', 'MAITHIRAN P', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(221, '921025103015', 'MENAKA DEVI K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(222, '921025103016', 'NISHA GANDHI S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(223, '921025103017', 'NIVEDHA MANI M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(224, '921025103018', 'PADMASRI N', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(225, '921025103019', 'PRASANNA DEVI G', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(226, '921025103020', 'RAMAKRISHNAN M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(227, '921025103021', 'RUBASREE K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(228, '921025103022', 'RUTHREVANTH S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(229, '921025103023', 'SANGEETHA M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(230, '921025103024', 'SARANYA A', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(231, '921025103025', 'SARAVANA KUMAR P', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(232, '921025103026', 'SATHANA R', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(233, '921025103027', 'SHARMILA DEVI M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(234, '921025103028', 'SRI KANTH M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(235, '921025103029', 'THARUNIMA S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(236, '921025103030', 'VIJAYA BHARATHI M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(237, '921025103031', 'YAZHINI N', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(238, '921025103032', 'YUVASRI M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(239, '921025104001', 'AATHISUNDARARAJAN N', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(240, '921025104002', 'AZLINA M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(241, '921025104003', 'BHARATHI M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(242, '921025104004', 'BHAVADHARANI M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(243, '921025104005', 'DEVA GURU G', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(244, '921025104006', 'DHANUSHA SRI J', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(245, '921025104007', 'DHARSHINI S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(246, '921025104008', 'DHARSHITH R', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(247, '921025104009', 'DIVYA K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(248, '921025104010', 'DURGALAKSHMI M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(249, '921025104011', 'GAYATHIRI M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(250, '921025104012', 'GOKULA KANNAN P G', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(251, '921025104013', 'HAASINI K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(252, '921025104014', 'HARIGARAN K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(253, '921025104015', 'HARINI K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(254, '921025104016', 'HARSHINI S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(255, '921025104017', 'HARSHITHA S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(256, '921025104018', 'IRFANA S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(257, '921025104019', 'JAYANTHRA K J', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(258, '921025104020', 'JEYA SREE P', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(259, '921025104021', 'JUHI NUSHRATH H', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(260, '921025104022', 'KARTHIK OMSHAKTHI K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(261, '921025104023', 'KAVIYA K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(262, '921025104024', 'LATHIKA K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(263, '921025104025', 'LISHANTHI S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(264, '921025104026', 'MAHIMA M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(265, '921025104027', 'MAHISHA S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(266, '921025104028', 'MANIKANDAN P', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(267, '921025104029', 'MEGADHARSHINI S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(268, '921025104030', 'MOHAMED AFSAL K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(269, '921025104031', 'MOHANASANTHOSH V', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(270, '921025104032', 'MONISHA S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(271, '921025104033', 'NETHRA V', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(272, '921025104034', 'NISHA K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(273, '921025104035', 'NITHARSHANA S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(274, '921025104036', 'POOJA SRI P', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(275, '921025104037', 'PRATHIKSHA SRI S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(276, '921025104038', 'PRINCYMISPHA C', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(277, '921025104039', 'PRIYADHARSHINI P', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(278, '921025104040', 'PUGAZHENTHI G', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(279, '921025104041', 'RAGA SRI V', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(280, '921025104042', 'RIYA R', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(281, '921025104043', 'SAMRUTHA P', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(282, '921025104044', 'SANTHANAGOWSHIKA K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(283, '921025104045', 'SANTHIYA C', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(284, '921025104046', 'SANTHOSI S', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(285, '921025104047', 'SELVALAKSHMI M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(286, '921025104048', 'SHAHANA P', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(287, '921025104049', 'SHAKTHI R', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(288, '921025104050', 'SIVAKUMAR K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(289, '921025104051', 'SOWMIYA A', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(290, '921025104052', 'SREEJA R', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(291, '921025104053', 'SRIVAISHNAVI M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(292, '921025104054', 'SUBATHRA M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(293, '921025104055', 'SURIYA T', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(294, '921025104056', 'VARSHINI K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(295, '921025104057', 'VISHAL R', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(296, '921025104058', 'YASHIKAJAISHREE M', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(297, '921025104059', 'YOKHITHA V', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03'),
(298, '921025104060', 'YOSHITHA K', '', '$2y$10$aobYtcFHjYBc9gRl5PC4X.1I1PdzXkVEQzaIJJBwGIHQNVEz36Y/K', 1, 1, 1, '2025-11-11 10:01:26', '2025-11-11 10:31:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analytics`
--
ALTER TABLE `analytics`
  ADD PRIMARY KEY (`analytics_id`),
  ADD KEY `fk_analytics_student` (`student_id`),
  ADD KEY `fk_analytics_test` (`test_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_name` (`short_name`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `student_test_id` (`student_test_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`leaderboard_id`),
  ADD KEY `fk_leaderboard_student` (`student_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `fk_sub_topic` (`sub_topic_id`),
  ADD KEY `fk_created_by` (`created_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD PRIMARY KEY (`student_answers_id`),
  ADD KEY `student_test_id` (`student_test_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `student_tests`
--
ALTER TABLE `student_tests`
  ADD PRIMARY KEY (`student_test_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexes for table `sub_topics`
--
ALTER TABLE `sub_topics`
  ADD PRIMARY KEY (`sub_topic_id`),
  ADD KEY `fk_subtopic_topic` (`topic_id`),
  ADD KEY `fk_subtopic_added_by` (`added_by`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`test_id`),
  ADD KEY `fk_tests_added_by` (`added_by`),
  ADD KEY `fk_tests_topic` (`topic_id`),
  ADD KEY `fk_tests_sub_topic` (`sub_topic_id`),
  ADD KEY `fk_tests_department` (`department_id`);

--
-- Indexes for table `test_questions`
--
ALTER TABLE `test_questions`
  ADD PRIMARY KEY (`test_question_id`),
  ADD KEY `fk_test` (`test_id`),
  ADD KEY `fk_question` (`question_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `fk_topic_added_by` (`added_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role` (`role_id`),
  ADD KEY `fk_department` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `student_tests`
--
ALTER TABLE `student_tests`
  MODIFY `student_test_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;

--
-- AUTO_INCREMENT for table `sub_topics`
--
ALTER TABLE `sub_topics`
  MODIFY `sub_topic_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `test_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `test_questions`
--
ALTER TABLE `test_questions`
  MODIFY `test_question_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sub_topic` FOREIGN KEY (`sub_topic_id`) REFERENCES `sub_topics` (`sub_topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_topics`
--
ALTER TABLE `sub_topics`
  ADD CONSTRAINT `fk_subtopic_added_by` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_subtopic_topic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `fk_tests_added_by` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tests_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tests_sub_topic` FOREIGN KEY (`sub_topic_id`) REFERENCES `sub_topics` (`sub_topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tests_topic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test_questions`
--
ALTER TABLE `test_questions`
  ADD CONSTRAINT `fk_question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_test` FOREIGN KEY (`test_id`) REFERENCES `tests` (`test_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `fk_topic_added_by` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
