-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2025 at 12:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iqarena`
--

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

CREATE TABLE `analytics` (
  `analytics_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `attempted` int(11) NOT NULL,
  `correct_answers` int(11) NOT NULL,
  `wrong_answers` int(11) NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `feedback_id` int(11) NOT NULL,
  `student_test_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `given_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `leaderboard_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `total_tests` int(11) DEFAULT 0,
  `total_score` decimal(10,2) DEFAULT 0.00,
  `average_score` decimal(5,2) DEFAULT 0.00,
  `highest_score` decimal(5,2) DEFAULT 0.00,
  `rank_position` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `reset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `sub_topic_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `by_admin` int(11) NOT NULL DEFAULT 1,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mark` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `sub_topic_id`, `created_by`, `by_admin`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `created_at`, `mark`) VALUES
(6, 1, 1, 0, 'What is the capital of India?', 'Mumbai', 'Chennai', 'New Delhi', 'Kolkata', 'C', '2025-08-22 01:13:51', 1),
(7, 1, 1, 0, 'Which data type is used to store decimal values in MySQL?', 'INT', 'VARCHAR', 'FLOAT', 'BOOLEAN', 'C', '2025-08-22 01:13:51', 1),
(8, 1, 1, 0, 'HTML stands for?', 'Hyperlinks and Text Markup Language', 'Hyper Text Markup Language', 'Home Tool Markup Language', 'High Transfer Markup Language', 'B', '2025-08-22 01:13:51', 1),
(69, 9, 2, 0, 'Who developed Python Programming Language?', 'Wick van Rossum', 'Rasmus Lerdorf', 'Guido van Rossum', 'Niene Stom', 'C', '2025-09-01 09:14:11', 1),
(70, 9, 2, 0, 'Which type of Programming does Python support?', 'object-oriented programming', 'structured programming', 'functional programming', 'all of the mentioned', 'D', '2025-09-01 09:14:11', 1),
(71, 9, 2, 0, 'Is Python case sensitive when dealing with identifiers?', 'no', 'yes', 'machine dependent', 'none of the mentioned', 'B', '2025-09-01 09:14:11', 1),
(72, 9, 2, 0, 'Which of the following is the correct extension of the Python file?', '.python', '.pl', '.py', '.p', 'C', '2025-09-01 09:14:11', 1),
(73, 9, 2, 0, 'Is Python code compiled or interpreted?', 'Python code is both compiled and interpreted', 'Python code is neither compiled nor interpreted', 'Python code is only compiled', 'Python code is only interpreted', 'A', '2025-09-01 09:14:11', 1),
(74, 9, 2, 0, 'All keywords in Python are in _________', 'Capitalized', 'lower case', 'UPPER CASE', 'None of the mentioned', 'D', '2025-09-01 09:14:11', 1),
(75, 9, 2, 0, 'What will be the value of the following Python expression? print(4 + 3 % 5)', '7', '2', '4', '1', 'A', '2025-09-01 09:14:11', 1),
(76, 9, 2, 0, 'Which of the following is used to define a block of code in Python language?', 'Indentation', 'Key', 'Brackets', 'All of the mentioned', 'A', '2025-09-01 09:14:11', 1),
(77, 9, 2, 0, 'Which keyword is used for function in Python language?', 'Function', 'def', 'Fun', 'Define', 'B', '2025-09-01 09:14:11', 1),
(78, 9, 2, 0, 'Which of the following character is used to give single-line comments in Python?', '//', '#', '!', '/*', 'B', '2025-09-01 09:14:11', 1),
(79, 9, 2, 0, 'Which keyword is used for function in Python language?', 'Function', 'def', 'Fun', 'Define', 'B', '2025-09-01 09:14:11', 1),
(80, 9, 2, 0, 'What will be the output of the following Python code?i = 1\r\nwhile True:\r\n    if i%3 == 0:\r\n        break\r\n    print(i)\r\n \r\n    i + = 1', '1 2 3 .', 'SyntaxError', '1 2', 'none of the mentioned', 'D', '2025-09-01 09:14:11', 1),
(81, 9, 2, 0, 'Which of the following functions can help us to find the version of python that we are currently working on?', 'sys.version(1)', 'sys.version(0)', 'sys.version()', 'sys.version', 'C', '2025-09-01 09:14:11', 1),
(82, 9, 2, 0, 'Python supports the creation of anonymous functions at runtime, using a construct called __________', 'pi', 'anonymous', 'lambda', 'none of the mentioned', 'D', '2025-09-01 09:14:11', 1),
(83, 9, 2, 0, 'What is the order of precedence in python?', 'Exponential, Parentheses, Multiplication, Division, Addition, Subtraction', 'Exponential, Parentheses, Division, Multiplication, Addition, Subtraction', 'Parentheses, Exponential, Multiplication, Addition, Division, Subtraction', 'Parentheses, Exponential, Multiplication, Division, Addition, Subtraction', 'A', '2025-09-01 09:14:11', 1),
(84, 9, 2, 0, 'What will be the output of the following Python code snippet if x=1?,    x<<2', '4', '2', '1', '8', 'C', '2025-09-01 09:14:11', 1),
(85, 9, 2, 0, 'What does pip stand for python?', 'Pip Installs Python', 'Pip Installs Packages', 'Preferred Installer Program', 'All of the mentioned', 'B', '2025-09-01 09:14:11', 1),
(86, 9, 2, 0, 'Which of the following is true for variable names in Python?', 'underscore and ampersand are the only two special characters allowed', 'unlimited length', 'all private members must have leading and trailing underscores', 'none of the mentioned', 'A', '2025-09-01 09:14:11', 1),
(87, 9, 2, 0, 'What are the values of the following Python expressions? print(2**(3**2))\r\nprint((2**3)**2)\r\nprint(2**3**2)', '512, 64, 512', '512, 512, 512', '64, 512, 64', '64, 64, 64', 'B', '2025-09-01 09:14:11', 1),
(88, 9, 2, 0, 'Which of the following is the truncation division operator in Python?', '|', '//', '/', '%', 'C', '2025-09-01 09:14:11', 1),
(89, 9, 2, 0, 'What will be the output of the following Python code?  l=[1, 0, 2, 0, \'hello\', \'\', []]\r\nprint(list(filter(bool, l)))', '[1, 0, 2, ‘hello’, ”, []]', 'Error', '[1, 2, ‘hello’]', '[1, 0, 2, 0, ‘hello’, ”, []]', 'B', '2025-09-01 09:14:11', 1),
(90, 9, 2, 0, 'Which of the following functions is a built-in function in python?', 'factorial()', 'print()', 'seed()', 'sqrt()', 'B', '2025-09-01 09:14:11', 1),
(91, 9, 2, 0, 'Which of the following is the use of id() function in python?', 'Every object doesn’t have a unique id', 'Id returns the identity of the object', 'All of the mentioned', 'None of the mentioned', 'A', '2025-09-01 09:14:11', 1),
(92, 9, 2, 0, 'What will be the output of the following Python function?   print(min(max(False,-3,-4), 2,7))', '-4', '-3', '2', 'FALSE', 'C', '2025-09-01 09:14:11', 1),
(93, 9, 2, 0, 'Which of the following is not a core data type in Python programming?', 'Tuples', 'Lists', 'Class', 'Dictionary', 'D', '2025-09-01 09:14:11', 1),
(94, 9, 2, 0, 'What will be the output of the following Python expression if x=56.236?    print(\"%.2f\"%x)', '56.236', '56.23', '56', '56.24', 'B', '2025-09-01 09:14:11', 1),
(95, 9, 2, 0, 'Which of these is the definition for packages in Python?', 'A set of main modules', 'A folder of python modules', 'A number of files containing Python definitions and statements', 'A set of programs making use of Python modules', 'C', '2025-09-01 09:14:11', 1),
(96, 9, 2, 0, 'What will be the output of the following Python function?    print(len([\"hello\",2, 4, 6]))', 'Error', '6', '4', '3', 'D', '2025-09-01 09:14:11', 1),
(97, 9, 2, 0, 'What will be the output of the following Python code?  x = \'abcd\'\r\nfor i in x:\r\n    print(i.upper())', 'a\r\nB\r\nC\r\nD', 'a b c d', 'error', 'A\r\nB\r\nC\r\nD', 'C', '2025-09-01 09:14:11', 1),
(98, 9, 2, 0, 'What is the order of namespaces in which Python looks for an identifier?', 'Python first searches the built-in namespace, then the global namespace and finally the local namespace', 'Python first searches the built-in namespace, then the local namespace and finally the global namespace', 'Python first searches the local namespace, then the global namespace and finally the built-in namespace', 'Python first searches the global namespace, then the local namespace and finally the built-in namespace', 'A', '2025-09-01 09:14:11', 1),
(99, 9, 2, 0, 'What will be the output of the following Python code snippet?   for i in [1, 2, 3, 4][::-1]:\r\n    print(i, end=\' \')', '4 3 2 1', 'error', '1 2 3 4', 'none of the mentioned', 'B', '2025-09-01 09:14:11', 1),
(100, 9, 2, 0, 'What will be the output of the following Python statement?  print(\"a\"+\"bc\")', 'bc', 'abc', 'a', 'bca', 'D', '2025-09-01 09:14:11', 1),
(101, 9, 2, 0, 'Which function is called when the following Python program is executed?    f = foo()\r\nformat(f)', 'str()', 'format()', '__str__()', '__format__()', 'B', '2025-09-01 09:14:11', 1),
(102, 9, 2, 0, 'What will be the output of the following Python code?            class tester:\r\n    def __init__(self, id):\r\n        self.id = str(id)\r\n        id=\"224\"\r\n \r\ntemp = tester(12)\r\nprint(temp.id)', '12', '224', 'None', 'Error', 'D', '2025-09-01 09:14:11', 1),
(103, 9, 2, 0, 'What will be the output of the following Python program?        def foo(x):\r\n    x[0] = [\'def\']\r\n    x[1] = [\'abc\']\r\n    return id(x)\r\nq = [\'abc\', \'def\']\r\nprint(id(q) == foo(q))', 'Error', 'None', 'FALSE', 'TRUE', 'B', '2025-09-01 09:14:11', 1),
(104, 9, 2, 0, 'Which module in the python standard library parses options received from the command line?', 'getarg', 'getopt', 'main', 'os', 'C', '2025-09-01 09:14:11', 1),
(105, 9, 2, 0, 'What will be the output of the following Python program?    z=set(\'abc\')\r\nz.add(\'san\')\r\nz.update(set([\'p\', \'q\']))\r\nprint(z)', '{‘a’, ‘c’, ‘c’, ‘p’, ‘q’, ‘s’, ‘a’, ‘n’}', '{‘abc’, ‘p’, ‘q’, ‘san’}', '{‘a’, ‘b’, ‘c’, ‘p’, ‘q’, ‘san’}', '{‘a’, ‘b’, ‘c’, [‘p’, ‘q’], ‘san}', 'B', '2025-09-01 09:14:11', 1),
(106, 9, 2, 0, 'What arithmetic operators cannot be used with strings in Python?', '*', '–', '+', 'All of the mentioned', 'A', '2025-09-01 09:14:11', 1),
(107, 9, 2, 0, 'What will be the output of the following Python code?    print(\"abc. DEF\".capitalize())', 'Abc. def', 'abc. def', 'Abc. Def', 'ABC. DEF', 'D', '2025-09-01 09:14:11', 1),
(108, 9, 2, 0, 'Which of the following statements is used to create an empty set in Python?', '( )', '[ ]', '{ }', 'set()', 'A', '2025-09-01 09:14:11', 1),
(109, 9, 2, 0, 'What will be the value of ‘result’ in following Python program?      list1 = [1,2,3,4]\r\nlist2 = [2,4,5,6]\r\nlist3 = [2,6,7,8]\r\nresult = list()\r\nresult.extend(i for i in list1 if i not in (list2+list3) and i not in result)\r\nresult.extend(i for i in list2 if i not in (list1+list3) and i not in result)\r\nresult.extend(i for i in list3 if i not in (list1+list2) and i not in result)\r\nprint(result)', '[1, 3, 5, 7, 8]', '[1, 7, 8]', '[1, 2, 4, 7, 8]', 'error', 'C', '2025-09-01 09:14:11', 1),
(110, 9, 2, 0, 'To add a new element to a list we use which Python command?', 'list1.addEnd(5)', 'list1.addLast(5)', 'list1.append(5)', 'list1.add(5)', 'B', '2025-09-01 09:14:11', 1),
(111, 9, 2, 0, 'What will be the output of the following Python code?      print(\'*\', \"abcde\".center(6), \'*\', sep=\'\')', '* abcde *', '*abcde *', '* abcde*', '* abcde *', 'C', '2025-09-01 09:14:11', 1),
(112, 9, 2, 0, 'What will be the output of the following Python code?      list1 = [1, 3]\r\nlist2 = list1\r\nlist1[0] = 4\r\nprint(list2)', '[1, 4]', '[1, 3, 4]', '[4, 3]', '[1, 3]', 'C', '2025-09-01 09:14:11', 1),
(113, 9, 2, 0, 'Which one of the following is the use of function in python?', 'Functions don’t provide better modularity for your application', 'you can’t also create your own functions', 'Functions are reusable pieces of programs', 'All of the mentioned', 'B', '2025-09-01 09:14:11', 1),
(114, 9, 2, 0, 'Which of the following Python statements will result in the output: 6?      A = [[1, 2, 3],\r\n     [4, 5, 6],\r\n     [7, 8, 9]]', 'A[2][1]', 'A[1][2]', 'A[3][2]', 'A[2][3]', 'D', '2025-09-01 09:14:11', 1),
(115, 9, 2, 0, 'What is the maximum possible length of an identifier in Python?', '79 characters', '31 characters', '63 characters', 'none of the mentioned', 'C', '2025-09-01 09:14:11', 1),
(116, 9, 2, 0, 'What will be the output of the following Python program?    i = 0\r\nwhile i < 5:\r\n    print(i)\r\n    i += 1\r\n    if i == 3:\r\n        break\r\nelse:\r\n    print(0)', 'error', '0\r\n1\r\n2\r\n3\r\n0', '0\r\n1\r\n2', 'none of the mentioned', 'D', '2025-09-01 09:14:11', 1),
(117, 9, 2, 0, 'What will be the output of the following Python code?    x = \'abcd\'\r\nfor i in range(len(x)):\r\n    print(i)', 'error', '1 2 3 4', 'a b c d', '0 1 2 3', 'C', '2025-09-01 09:14:11', 1),
(118, 9, 2, 0, 'What are the two main types of functions in Python?', 'System function', 'Custom function', 'Built-in function & User defined function', 'User function', 'A', '2025-09-01 09:14:11', 1),
(119, 9, 2, 0, 'What will be the output of the following Python program?      def addItem(listParam):\r\n    listParam += [1]\r\n \r\nmylist = [1, 2, 3, 4]\r\naddItem(mylist)\r\nprint(len(mylist))', '5', '8', '2', '1', 'D', '2025-09-01 09:14:11', 1),
(120, 9, 2, 0, 'Which of the following is a Python tuple?', '{1, 2, 3}', '{}', '[1, 2, 3]', '(1, 2, 3)', 'B', '2025-09-01 09:14:11', 1),
(121, 9, 2, 0, 'What will be the output of the following Python expression?   print(round(4.576))', '4', '4.6', '5', '4.5', 'C', '2025-09-01 09:14:11', 1),
(122, 9, 2, 0, 'Which of the following is a feature of Python DocString?', 'In Python all functions should have a docstring', 'Docstrings can be accessed by the __doc__ attribute on objects', 'It provides a convenient way of associating documentation with Python modules, functions, classes, and methods', 'All of the mentioned', 'D', '2025-09-01 09:14:11', 1),
(123, 9, 2, 0, 'What will be the output of the following Python code?     print(\"Hello {0[0]} and {0[1]}\".format((\'foo\', \'bin\')))', 'Hello (‘foo’, ‘bin’) and (‘foo’, ‘bin’)', 'Error', 'Hello foo and bin', 'None of the mentioned', 'C', '2025-09-01 09:14:11', 1),
(124, 9, 2, 0, 'What is output of print(math.pow(3, 2))?', '9 . 0', 'None', '9', 'None of the mentioned', 'A', '2025-09-01 09:14:11', 1),
(125, 9, 2, 0, 'Which of the following is the use of id() function in python?', 'Every object in Python doesn’t have a unique id', 'In Python Id function returns the identity of the object', 'None of the mentioned', 'All of the mentioned', 'B', '2025-09-01 09:14:11', 1),
(126, 9, 2, 0, 'What will be the output of the following Python code?     x = [[0], [1]]\r\nprint((\' \'.join(list(map(str, x))),))', '0 1', '[0] [1]', '(’01’)', '(‘[0] [1]’,)', 'D', '2025-09-01 09:14:11', 1),
(127, 9, 2, 0, 'Who developed Python Programming Language?', 'Wick van Rossum', 'Rasmus Lerdorf', 'Guido van Rossum', 'Niene Stom', 'C', '2025-09-01 09:17:00', 1),
(128, 9, 2, 0, 'Which type of Programming does Python support?', 'object-oriented programming', 'structured programming', 'functional programming', 'all of the mentioned', 'D', '2025-09-01 09:17:00', 1),
(129, 9, 2, 0, 'Is Python case sensitive when dealing with identifiers?', 'no', 'yes', 'machine dependent', 'none of the mentioned', 'B', '2025-09-01 09:17:00', 1),
(130, 9, 2, 0, 'Which of the following is the correct extension of the Python file?', '.python', '.pl', '.py', '.p', 'C', '2025-09-01 09:17:00', 1),
(131, 9, 2, 0, 'Is Python code compiled or interpreted?', 'Python code is both compiled and interpreted', 'Python code is neither compiled nor interpreted', 'Python code is only compiled', 'Python code is only interpreted', 'A', '2025-09-01 09:17:00', 1),
(132, 9, 2, 0, 'All keywords in Python are in _________', 'Capitalized', 'lower case', 'UPPER CASE', 'None of the mentioned', 'D', '2025-09-01 09:17:00', 1),
(133, 9, 2, 0, 'What will be the value of the following Python expression? print(4 + 3 % 5)', '7', '2', '4', '1', 'A', '2025-09-01 09:17:00', 1),
(134, 9, 2, 0, 'Which of the following is used to define a block of code in Python language?', 'Indentation', 'Key', 'Brackets', 'All of the mentioned', 'A', '2025-09-01 09:17:00', 1),
(135, 9, 2, 0, 'Which keyword is used for function in Python language?', 'Function', 'def', 'Fun', 'Define', 'B', '2025-09-01 09:17:00', 1),
(136, 9, 2, 0, 'Which of the following character is used to give single-line comments in Python?', '//', '#', '!', '/*', 'B', '2025-09-01 09:17:00', 1),
(137, 9, 2, 0, 'Which keyword is used for function in Python language?', 'Function', 'def', 'Fun', 'Define', 'B', '2025-09-01 09:17:00', 1),
(138, 9, 2, 0, 'What will be the output of the following Python code?i = 1\r\nwhile True:\r\n    if i%3 == 0:\r\n        break\r\n    print(i)\r\n \r\n    i + = 1', '1 2 3 .', 'SyntaxError', '1 2', 'none of the mentioned', 'D', '2025-09-01 09:17:00', 1),
(139, 9, 2, 0, 'Which of the following functions can help us to find the version of python that we are currently working on?', 'sys.version(1)', 'sys.version(0)', 'sys.version()', 'sys.version', 'C', '2025-09-01 09:17:00', 1),
(140, 9, 2, 0, 'Python supports the creation of anonymous functions at runtime, using a construct called __________', 'pi', 'anonymous', 'lambda', 'none of the mentioned', 'D', '2025-09-01 09:17:00', 1),
(141, 9, 2, 0, 'What is the order of precedence in python?', 'Exponential, Parentheses, Multiplication, Division, Addition, Subtraction', 'Exponential, Parentheses, Division, Multiplication, Addition, Subtraction', 'Parentheses, Exponential, Multiplication, Addition, Division, Subtraction', 'Parentheses, Exponential, Multiplication, Division, Addition, Subtraction', 'A', '2025-09-01 09:17:00', 1),
(142, 9, 2, 0, 'What will be the output of the following Python code snippet if x=1?,    x<<2', '4', '2', '1', '8', 'C', '2025-09-01 09:17:00', 1),
(143, 9, 2, 0, 'What does pip stand for python?', 'Pip Installs Python', 'Pip Installs Packages', 'Preferred Installer Program', 'All of the mentioned', 'B', '2025-09-01 09:17:00', 1),
(144, 9, 2, 0, 'Which of the following is true for variable names in Python?', 'underscore and ampersand are the only two special characters allowed', 'unlimited length', 'all private members must have leading and trailing underscores', 'none of the mentioned', 'A', '2025-09-01 09:17:00', 1),
(145, 9, 2, 0, 'What are the values of the following Python expressions? print(2**(3**2))\r\nprint((2**3)**2)\r\nprint(2**3**2)', '512, 64, 512', '512, 512, 512', '64, 512, 64', '64, 64, 64', 'B', '2025-09-01 09:17:00', 1),
(146, 9, 2, 0, 'Which of the following is the truncation division operator in Python?', '|', '//', '/', '%', 'C', '2025-09-01 09:17:00', 1),
(147, 9, 2, 0, 'What will be the output of the following Python code?  l=[1, 0, 2, 0, \'hello\', \'\', []]\r\nprint(list(filter(bool, l)))', '[1, 0, 2, ‘hello’, ”, []]', 'Error', '[1, 2, ‘hello’]', '[1, 0, 2, 0, ‘hello’, ”, []]', 'B', '2025-09-01 09:17:00', 1),
(148, 9, 2, 0, 'Which of the following functions is a built-in function in python?', 'factorial()', 'print()', 'seed()', 'sqrt()', 'B', '2025-09-01 09:17:00', 1),
(149, 9, 2, 0, 'Which of the following is the use of id() function in python?', 'Every object doesn’t have a unique id', 'Id returns the identity of the object', 'All of the mentioned', 'None of the mentioned', 'A', '2025-09-01 09:17:00', 1),
(150, 9, 2, 0, 'What will be the output of the following Python function?   print(min(max(False,-3,-4), 2,7))', '-4', '-3', '2', 'FALSE', 'C', '2025-09-01 09:17:00', 1),
(151, 9, 2, 0, 'Which of the following is not a core data type in Python programming?', 'Tuples', 'Lists', 'Class', 'Dictionary', 'D', '2025-09-01 09:17:00', 1),
(152, 9, 2, 0, 'What will be the output of the following Python expression if x=56.236?    print(\"%.2f\"%x)', '56.236', '56.23', '56', '56.24', 'B', '2025-09-01 09:17:00', 1),
(153, 9, 2, 0, 'Which of these is the definition for packages in Python?', 'A set of main modules', 'A folder of python modules', 'A number of files containing Python definitions and statements', 'A set of programs making use of Python modules', 'C', '2025-09-01 09:17:00', 1),
(154, 9, 2, 0, 'What will be the output of the following Python function?    print(len([\"hello\",2, 4, 6]))', 'Error', '6', '4', '3', 'D', '2025-09-01 09:17:00', 1),
(155, 9, 2, 0, 'What will be the output of the following Python code?  x = \'abcd\'\r\nfor i in x:\r\n    print(i.upper())', 'a\r\nB\r\nC\r\nD', 'a b c d', 'error', 'A\r\nB\r\nC\r\nD', 'C', '2025-09-01 09:17:00', 1),
(156, 9, 2, 0, 'What is the order of namespaces in which Python looks for an identifier?', 'Python first searches the built-in namespace, then the global namespace and finally the local namespace', 'Python first searches the built-in namespace, then the local namespace and finally the global namespace', 'Python first searches the local namespace, then the global namespace and finally the built-in namespace', 'Python first searches the global namespace, then the local namespace and finally the built-in namespace', 'A', '2025-09-01 09:17:00', 1),
(157, 9, 2, 0, 'What will be the output of the following Python code snippet?   for i in [1, 2, 3, 4][::-1]:\r\n    print(i, end=\' \')', '4 3 2 1', 'error', '1 2 3 4', 'none of the mentioned', 'B', '2025-09-01 09:17:00', 1),
(158, 9, 2, 0, 'What will be the output of the following Python statement?  print(\"a\"+\"bc\")', 'bc', 'abc', 'a', 'bca', 'D', '2025-09-01 09:17:00', 1),
(159, 9, 2, 0, 'Which function is called when the following Python program is executed?    f = foo()\r\nformat(f)', 'str()', 'format()', '__str__()', '__format__()', 'B', '2025-09-01 09:17:00', 1),
(160, 9, 2, 0, 'What will be the output of the following Python code?            class tester:\r\n    def __init__(self, id):\r\n        self.id = str(id)\r\n        id=\"224\"\r\n \r\ntemp = tester(12)\r\nprint(temp.id)', '12', '224', 'None', 'Error', 'D', '2025-09-01 09:17:00', 1),
(161, 9, 2, 0, 'What will be the output of the following Python program?        def foo(x):\r\n    x[0] = [\'def\']\r\n    x[1] = [\'abc\']\r\n    return id(x)\r\nq = [\'abc\', \'def\']\r\nprint(id(q) == foo(q))', 'Error', 'None', 'FALSE', 'TRUE', 'B', '2025-09-01 09:17:00', 1),
(162, 9, 2, 0, 'Which module in the python standard library parses options received from the command line?', 'getarg', 'getopt', 'main', 'os', 'C', '2025-09-01 09:17:00', 1),
(163, 9, 2, 0, 'What will be the output of the following Python program?    z=set(\'abc\')\r\nz.add(\'san\')\r\nz.update(set([\'p\', \'q\']))\r\nprint(z)', '{‘a’, ‘c’, ‘c’, ‘p’, ‘q’, ‘s’, ‘a’, ‘n’}', '{‘abc’, ‘p’, ‘q’, ‘san’}', '{‘a’, ‘b’, ‘c’, ‘p’, ‘q’, ‘san’}', '{‘a’, ‘b’, ‘c’, [‘p’, ‘q’], ‘san}', 'B', '2025-09-01 09:17:00', 1),
(164, 9, 2, 0, 'What arithmetic operators cannot be used with strings in Python?', '*', '–', '+', 'All of the mentioned', 'A', '2025-09-01 09:17:00', 1),
(165, 9, 2, 0, 'What will be the output of the following Python code?    print(\"abc. DEF\".capitalize())', 'Abc. def', 'abc. def', 'Abc. Def', 'ABC. DEF', 'D', '2025-09-01 09:17:00', 1),
(166, 9, 2, 0, 'Which of the following statements is used to create an empty set in Python?', '( )', '[ ]', '{ }', 'set()', 'A', '2025-09-01 09:17:00', 1),
(167, 9, 2, 0, 'What will be the value of ‘result’ in following Python program?      list1 = [1,2,3,4]\r\nlist2 = [2,4,5,6]\r\nlist3 = [2,6,7,8]\r\nresult = list()\r\nresult.extend(i for i in list1 if i not in (list2+list3) and i not in result)\r\nresult.extend(i for i in list2 if i not in (list1+list3) and i not in result)\r\nresult.extend(i for i in list3 if i not in (list1+list2) and i not in result)\r\nprint(result)', '[1, 3, 5, 7, 8]', '[1, 7, 8]', '[1, 2, 4, 7, 8]', 'error', 'C', '2025-09-01 09:17:00', 1),
(168, 9, 2, 0, 'To add a new element to a list we use which Python command?', 'list1.addEnd(5)', 'list1.addLast(5)', 'list1.append(5)', 'list1.add(5)', 'B', '2025-09-01 09:17:00', 1),
(169, 9, 2, 0, 'What will be the output of the following Python code?      print(\'*\', \"abcde\".center(6), \'*\', sep=\'\')', '* abcde *', '*abcde *', '* abcde*', '* abcde *', 'C', '2025-09-01 09:17:00', 1),
(170, 9, 2, 0, 'What will be the output of the following Python code?      list1 = [1, 3]\r\nlist2 = list1\r\nlist1[0] = 4\r\nprint(list2)', '[1, 4]', '[1, 3, 4]', '[4, 3]', '[1, 3]', 'C', '2025-09-01 09:17:00', 1),
(171, 9, 2, 0, 'Which one of the following is the use of function in python?', 'Functions don’t provide better modularity for your application', 'you can’t also create your own functions', 'Functions are reusable pieces of programs', 'All of the mentioned', 'B', '2025-09-01 09:17:00', 1),
(172, 9, 2, 0, 'Which of the following Python statements will result in the output: 6?      A = [[1, 2, 3],\r\n     [4, 5, 6],\r\n     [7, 8, 9]]', 'A[2][1]', 'A[1][2]', 'A[3][2]', 'A[2][3]', 'D', '2025-09-01 09:17:00', 1),
(173, 9, 2, 0, 'What is the maximum possible length of an identifier in Python?', '79 characters', '31 characters', '63 characters', 'none of the mentioned', 'C', '2025-09-01 09:17:00', 1),
(174, 9, 2, 0, 'What will be the output of the following Python program?    i = 0\r\nwhile i < 5:\r\n    print(i)\r\n    i += 1\r\n    if i == 3:\r\n        break\r\nelse:\r\n    print(0)', 'error', '0\r\n1\r\n2\r\n3\r\n0', '0\r\n1\r\n2', 'none of the mentioned', 'D', '2025-09-01 09:17:00', 1),
(175, 9, 2, 0, 'What will be the output of the following Python code?    x = \'abcd\'\r\nfor i in range(len(x)):\r\n    print(i)', 'error', '1 2 3 4', 'a b c d', '0 1 2 3', 'C', '2025-09-01 09:17:00', 1),
(176, 9, 2, 0, 'What are the two main types of functions in Python?', 'System function', 'Custom function', 'Built-in function & User defined function', 'User function', 'A', '2025-09-01 09:17:00', 1),
(177, 9, 2, 0, 'What will be the output of the following Python program?      def addItem(listParam):\r\n    listParam += [1]\r\n \r\nmylist = [1, 2, 3, 4]\r\naddItem(mylist)\r\nprint(len(mylist))', '5', '8', '2', '1', 'D', '2025-09-01 09:17:00', 1),
(178, 9, 2, 0, 'Which of the following is a Python tuple?', '{1, 2, 3}', '{}', '[1, 2, 3]', '(1, 2, 3)', 'B', '2025-09-01 09:17:00', 1),
(179, 9, 2, 0, 'What will be the output of the following Python expression?   print(round(4.576))', '4', '4.6', '5', '4.5', 'C', '2025-09-01 09:17:00', 1),
(180, 9, 2, 0, 'Which of the following is a feature of Python DocString?', 'In Python all functions should have a docstring', 'Docstrings can be accessed by the __doc__ attribute on objects', 'It provides a convenient way of associating documentation with Python modules, functions, classes, and methods', 'All of the mentioned', 'D', '2025-09-01 09:17:00', 1),
(181, 9, 2, 0, 'What will be the output of the following Python code?     print(\"Hello {0[0]} and {0[1]}\".format((\'foo\', \'bin\')))', 'Hello (‘foo’, ‘bin’) and (‘foo’, ‘bin’)', 'Error', 'Hello foo and bin', 'None of the mentioned', 'C', '2025-09-01 09:17:00', 1),
(182, 9, 2, 0, 'What is output of print(math.pow(3, 2))?', '9 . 0', 'None', '9', 'None of the mentioned', 'A', '2025-09-01 09:17:00', 1),
(183, 9, 2, 0, 'Which of the following is the use of id() function in python?', 'Every object in Python doesn’t have a unique id', 'In Python Id function returns the identity of the object', 'None of the mentioned', 'All of the mentioned', 'B', '2025-09-01 09:17:00', 1),
(184, 9, 2, 0, 'What will be the output of the following Python code?     x = [[0], [1]]\r\nprint((\' \'.join(list(map(str, x))),))', '0 1', '[0] [1]', '(’01’)', '(‘[0] [1]’,)', 'D', '2025-09-01 09:17:00', 1),
(185, 10, 2, 0, 'Who developed Python Programming Language?', 'Wick van Rossum', 'Rasmus Lerdorf', 'Guido van Rossum', 'Niene Stom', 'C', '2025-09-01 09:41:26', 1),
(186, 10, 2, 0, 'Which type of Programming does Python support?', 'object-oriented programming', 'structured programming', 'functional programming', 'all of the mentioned', 'D', '2025-09-01 09:41:26', 1),
(187, 10, 2, 0, 'Is Python case sensitive when dealing with identifiers?', 'no', 'yes', 'machine dependent', 'none of the mentioned', 'B', '2025-09-01 09:41:26', 1),
(188, 10, 2, 0, 'Which of the following is the correct extension of the Python file?', '.python', '.pl', '.py', '.p', 'C', '2025-09-01 09:41:26', 1),
(189, 10, 2, 0, 'Is Python code compiled or interpreted?', 'Python code is both compiled and interpreted', 'Python code is neither compiled nor interpreted', 'Python code is only compiled', 'Python code is only interpreted', 'A', '2025-09-01 09:41:26', 1),
(190, 10, 2, 0, 'All keywords in Python are in _________', 'Capitalized', 'lower case', 'UPPER CASE', 'None of the mentioned', 'D', '2025-09-01 09:41:26', 1),
(191, 10, 2, 0, 'What will be the value of the following Python expression? print(4 + 3 % 5)', '7', '2', '4', '1', 'A', '2025-09-01 09:41:26', 1),
(192, 10, 2, 0, 'Which of the following is used to define a block of code in Python language?', 'Indentation', 'Key', 'Brackets', 'All of the mentioned', 'A', '2025-09-01 09:41:26', 1),
(193, 10, 2, 0, 'Which keyword is used for function in Python language?', 'Function', 'def', 'Fun', 'Define', 'B', '2025-09-01 09:41:26', 1),
(194, 10, 2, 0, 'Which of the following character is used to give single-line comments in Python?', '//', '#', '!', '/*', 'B', '2025-09-01 09:41:26', 1),
(195, 10, 2, 0, 'Which keyword is used for function in Python language?', 'Function', 'def', 'Fun', 'Define', 'B', '2025-09-01 09:41:26', 1),
(196, 10, 2, 0, 'What will be the output of the following Python code?i = 1\r\nwhile True:\r\n    if i%3 == 0:\r\n        break\r\n    print(i)\r\n \r\n    i + = 1', '1 2 3 .', 'SyntaxError', '1 2', 'none of the mentioned', 'D', '2025-09-01 09:41:26', 1),
(197, 10, 2, 0, 'Which of the following functions can help us to find the version of python that we are currently working on?', 'sys.version(1)', 'sys.version(0)', 'sys.version()', 'sys.version', 'C', '2025-09-01 09:41:26', 1),
(198, 10, 2, 0, 'Python supports the creation of anonymous functions at runtime, using a construct called __________', 'pi', 'anonymous', 'lambda', 'none of the mentioned', 'D', '2025-09-01 09:41:26', 1),
(199, 10, 2, 0, 'What is the order of precedence in python?', 'Exponential, Parentheses, Multiplication, Division, Addition, Subtraction', 'Exponential, Parentheses, Division, Multiplication, Addition, Subtraction', 'Parentheses, Exponential, Multiplication, Addition, Division, Subtraction', 'Parentheses, Exponential, Multiplication, Division, Addition, Subtraction', 'A', '2025-09-01 09:41:26', 1),
(200, 10, 2, 0, 'What will be the output of the following Python code snippet if x=1?,    x<<2', '4', '2', '1', '8', 'C', '2025-09-01 09:41:26', 1),
(201, 10, 2, 0, 'What does pip stand for python?', 'Pip Installs Python', 'Pip Installs Packages', 'Preferred Installer Program', 'All of the mentioned', 'B', '2025-09-01 09:41:26', 1),
(202, 10, 2, 0, 'Which of the following is true for variable names in Python?', 'underscore and ampersand are the only two special characters allowed', 'unlimited length', 'all private members must have leading and trailing underscores', 'none of the mentioned', 'A', '2025-09-01 09:41:26', 1),
(203, 10, 2, 0, 'What are the values of the following Python expressions? print(2**(3**2))\r\nprint((2**3)**2)\r\nprint(2**3**2)', '512, 64, 512', '512, 512, 512', '64, 512, 64', '64, 64, 64', 'B', '2025-09-01 09:41:26', 1),
(204, 10, 2, 0, 'Which of the following is the truncation division operator in Python?', '|', '//', '/', '%', 'C', '2025-09-01 09:41:26', 1),
(205, 10, 2, 0, 'What will be the output of the following Python code?  l=[1, 0, 2, 0, \'hello\', \'\', []]\r\nprint(list(filter(bool, l)))', '[1, 0, 2, ‘hello’, ”, []]', 'Error', '[1, 2, ‘hello’]', '[1, 0, 2, 0, ‘hello’, ”, []]', 'B', '2025-09-01 09:41:26', 1),
(206, 10, 2, 0, 'Which of the following functions is a built-in function in python?', 'factorial()', 'print()', 'seed()', 'sqrt()', 'B', '2025-09-01 09:41:26', 1),
(207, 10, 2, 0, 'Which of the following is the use of id() function in python?', 'Every object doesn’t have a unique id', 'Id returns the identity of the object', 'All of the mentioned', 'None of the mentioned', 'A', '2025-09-01 09:41:26', 1),
(208, 10, 2, 0, 'What will be the output of the following Python function?   print(min(max(False,-3,-4), 2,7))', '-4', '-3', '2', 'FALSE', 'C', '2025-09-01 09:41:26', 1),
(209, 10, 2, 0, 'Which of the following is not a core data type in Python programming?', 'Tuples', 'Lists', 'Class', 'Dictionary', 'D', '2025-09-01 09:41:26', 1),
(210, 10, 2, 0, 'What will be the output of the following Python expression if x=56.236?    print(\"%.2f\"%x)', '56.236', '56.23', '56', '56.24', 'B', '2025-09-01 09:41:26', 1),
(211, 10, 2, 0, 'Which of these is the definition for packages in Python?', 'A set of main modules', 'A folder of python modules', 'A number of files containing Python definitions and statements', 'A set of programs making use of Python modules', 'C', '2025-09-01 09:41:26', 1),
(212, 10, 2, 0, 'What will be the output of the following Python function?    print(len([\"hello\",2, 4, 6]))', 'Error', '6', '4', '3', 'D', '2025-09-01 09:41:26', 1),
(213, 10, 2, 0, 'What will be the output of the following Python code?  x = \'abcd\'\r\nfor i in x:\r\n    print(i.upper())', 'a\r\nB\r\nC\r\nD', 'a b c d', 'error', 'A\r\nB\r\nC\r\nD', 'C', '2025-09-01 09:41:26', 1),
(214, 10, 2, 0, 'What is the order of namespaces in which Python looks for an identifier?', 'Python first searches the built-in namespace, then the global namespace and finally the local namespace', 'Python first searches the built-in namespace, then the local namespace and finally the global namespace', 'Python first searches the local namespace, then the global namespace and finally the built-in namespace', 'Python first searches the global namespace, then the local namespace and finally the built-in namespace', 'A', '2025-09-01 09:41:26', 1),
(215, 10, 2, 0, 'What will be the output of the following Python code snippet?   for i in [1, 2, 3, 4][::-1]:\r\n    print(i, end=\' \')', '4 3 2 1', 'error', '1 2 3 4', 'none of the mentioned', 'B', '2025-09-01 09:41:26', 1),
(216, 10, 2, 0, 'What will be the output of the following Python statement?  print(\"a\"+\"bc\")', 'bc', 'abc', 'a', 'bca', 'D', '2025-09-01 09:41:26', 1),
(217, 10, 2, 0, 'Which function is called when the following Python program is executed?    f = foo()\r\nformat(f)', 'str()', 'format()', '__str__()', '__format__()', 'B', '2025-09-01 09:41:26', 1),
(218, 10, 2, 0, 'What will be the output of the following Python code?            class tester:\r\n    def __init__(self, id):\r\n        self.id = str(id)\r\n        id=\"224\"\r\n \r\ntemp = tester(12)\r\nprint(temp.id)', '12', '224', 'None', 'Error', 'D', '2025-09-01 09:41:26', 1),
(219, 10, 2, 0, 'What will be the output of the following Python program?        def foo(x):\r\n    x[0] = [\'def\']\r\n    x[1] = [\'abc\']\r\n    return id(x)\r\nq = [\'abc\', \'def\']\r\nprint(id(q) == foo(q))', 'Error', 'None', 'FALSE', 'TRUE', 'B', '2025-09-01 09:41:26', 1),
(220, 10, 2, 0, 'Which module in the python standard library parses options received from the command line?', 'getarg', 'getopt', 'main', 'os', 'C', '2025-09-01 09:41:26', 1),
(221, 10, 2, 0, 'What will be the output of the following Python program?    z=set(\'abc\')\r\nz.add(\'san\')\r\nz.update(set([\'p\', \'q\']))\r\nprint(z)', '{‘a’, ‘c’, ‘c’, ‘p’, ‘q’, ‘s’, ‘a’, ‘n’}', '{‘abc’, ‘p’, ‘q’, ‘san’}', '{‘a’, ‘b’, ‘c’, ‘p’, ‘q’, ‘san’}', '{‘a’, ‘b’, ‘c’, [‘p’, ‘q’], ‘san}', 'B', '2025-09-01 09:41:26', 1),
(222, 10, 2, 0, 'What arithmetic operators cannot be used with strings in Python?', '*', '–', '+', 'All of the mentioned', 'A', '2025-09-01 09:41:26', 1),
(223, 10, 2, 0, 'What will be the output of the following Python code?    print(\"abc. DEF\".capitalize())', 'Abc. def', 'abc. def', 'Abc. Def', 'ABC. DEF', 'D', '2025-09-01 09:41:26', 1),
(224, 10, 2, 0, 'Which of the following statements is used to create an empty set in Python?', '( )', '[ ]', '{ }', 'set()', 'A', '2025-09-01 09:41:26', 1),
(225, 10, 2, 0, 'What will be the value of ‘result’ in following Python program?      list1 = [1,2,3,4]\r\nlist2 = [2,4,5,6]\r\nlist3 = [2,6,7,8]\r\nresult = list()\r\nresult.extend(i for i in list1 if i not in (list2+list3) and i not in result)\r\nresult.extend(i for i in list2 if i not in (list1+list3) and i not in result)\r\nresult.extend(i for i in list3 if i not in (list1+list2) and i not in result)\r\nprint(result)', '[1, 3, 5, 7, 8]', '[1, 7, 8]', '[1, 2, 4, 7, 8]', 'error', 'C', '2025-09-01 09:41:26', 1),
(226, 10, 2, 0, 'To add a new element to a list we use which Python command?', 'list1.addEnd(5)', 'list1.addLast(5)', 'list1.append(5)', 'list1.add(5)', 'B', '2025-09-01 09:41:26', 1),
(227, 10, 2, 0, 'What will be the output of the following Python code?      print(\'*\', \"abcde\".center(6), \'*\', sep=\'\')', '* abcde *', '*abcde *', '* abcde*', '* abcde *', 'C', '2025-09-01 09:41:26', 1),
(228, 10, 2, 0, 'What will be the output of the following Python code?      list1 = [1, 3]\r\nlist2 = list1\r\nlist1[0] = 4\r\nprint(list2)', '[1, 4]', '[1, 3, 4]', '[4, 3]', '[1, 3]', 'C', '2025-09-01 09:41:26', 1),
(229, 10, 2, 0, 'Which one of the following is the use of function in python?', 'Functions don’t provide better modularity for your application', 'you can’t also create your own functions', 'Functions are reusable pieces of programs', 'All of the mentioned', 'B', '2025-09-01 09:41:26', 1),
(230, 10, 2, 0, 'Which of the following Python statements will result in the output: 6?      A = [[1, 2, 3],\r\n     [4, 5, 6],\r\n     [7, 8, 9]]', 'A[2][1]', 'A[1][2]', 'A[3][2]', 'A[2][3]', 'D', '2025-09-01 09:41:26', 1),
(231, 10, 2, 0, 'What is the maximum possible length of an identifier in Python?', '79 characters', '31 characters', '63 characters', 'none of the mentioned', 'C', '2025-09-01 09:41:26', 1),
(232, 10, 2, 0, 'What will be the output of the following Python program?    i = 0\r\nwhile i < 5:\r\n    print(i)\r\n    i += 1\r\n    if i == 3:\r\n        break\r\nelse:\r\n    print(0)', 'error', '0\r\n1\r\n2\r\n3\r\n0', '0\r\n1\r\n2', 'none of the mentioned', 'D', '2025-09-01 09:41:26', 1),
(233, 10, 2, 0, 'What will be the output of the following Python code?    x = \'abcd\'\r\nfor i in range(len(x)):\r\n    print(i)', 'error', '1 2 3 4', 'a b c d', '0 1 2 3', 'C', '2025-09-01 09:41:26', 1),
(234, 10, 2, 0, 'What are the two main types of functions in Python?', 'System function', 'Custom function', 'Built-in function & User defined function', 'User function', 'A', '2025-09-01 09:41:26', 1),
(235, 10, 2, 0, 'What will be the output of the following Python program?      def addItem(listParam):\r\n    listParam += [1]\r\n \r\nmylist = [1, 2, 3, 4]\r\naddItem(mylist)\r\nprint(len(mylist))', '5', '8', '2', '1', 'D', '2025-09-01 09:41:26', 1),
(236, 10, 2, 0, 'Which of the following is a Python tuple?', '{1, 2, 3}', '{}', '[1, 2, 3]', '(1, 2, 3)', 'B', '2025-09-01 09:41:26', 1),
(237, 10, 2, 0, 'What will be the output of the following Python expression?   print(round(4.576))', '4', '4.6', '5', '4.5', 'C', '2025-09-01 09:41:26', 1),
(238, 10, 2, 0, 'Which of the following is a feature of Python DocString?', 'In Python all functions should have a docstring', 'Docstrings can be accessed by the __doc__ attribute on objects', 'It provides a convenient way of associating documentation with Python modules, functions, classes, and methods', 'All of the mentioned', 'D', '2025-09-01 09:41:26', 1),
(239, 10, 2, 0, 'What will be the output of the following Python code?     print(\"Hello {0[0]} and {0[1]}\".format((\'foo\', \'bin\')))', 'Hello (‘foo’, ‘bin’) and (‘foo’, ‘bin’)', 'Error', 'Hello foo and bin', 'None of the mentioned', 'C', '2025-09-01 09:41:26', 1),
(240, 10, 2, 0, 'What is output of print(math.pow(3, 2))?', '9 . 0', 'None', '9', 'None of the mentioned', 'A', '2025-09-01 09:41:26', 1),
(241, 10, 2, 0, 'Which of the following is the use of id() function in python?', 'Every object in Python doesn’t have a unique id', 'In Python Id function returns the identity of the object', 'None of the mentioned', 'All of the mentioned', 'B', '2025-09-01 09:41:26', 1),
(242, 10, 2, 0, 'What will be the output of the following Python code?     x = [[0], [1]]\r\nprint((\' \'.join(list(map(str, x))),))', '0 1', '[0] [1]', '(’01’)', '(‘[0] [1]’,)', 'D', '2025-09-01 09:41:26', 1),
(243, 9, 2, 0, 'What is the capital of India?', 'Mumbai', 'Chennai', 'New Delhi', 'Kolkata', 'C', '2025-09-02 10:40:43', 1),
(244, 9, 2, 0, 'Which data type is used to store decimal values in MySQL?', 'INT', 'VARCHAR', 'FLOAT', 'BOOLEAN', 'C', '2025-09-02 10:40:43', 1),
(245, 9, 2, 0, 'HTML stands for?', 'Hyperlinks and Text Markup Language', 'Hyper Text Markup Language', 'Home Tool Markup Language', 'High Transfer Markup Language', 'B', '2025-09-02 10:40:43', 1),
(246, 9, 2, 0, 'Which SQL command is used to extract data from a database?', 'GET', 'EXTRACT', 'SELECT', 'SHOW', 'C', '2025-09-02 10:40:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `student_answers_id` int(11) NOT NULL,
  `student_test_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` text DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `marked_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_answers`
--

INSERT INTO `student_answers` (`student_answers_id`, `student_test_id`, `question_id`, `answer`, `is_correct`, `marked_at`) VALUES
(99, 37, 188, 'C', 1, '2025-09-01 21:54:54'),
(100, 37, 196, 'C', 0, '2025-09-01 21:54:54'),
(101, 37, 199, 'C', 0, '2025-09-01 21:54:54'),
(102, 37, 202, 'B', 0, '2025-09-01 21:54:54'),
(103, 37, 221, 'D', 0, '2025-09-01 21:54:54'),
(104, 37, 222, 'B', 0, '2025-09-01 21:54:54'),
(105, 37, 225, 'D', 0, '2025-09-01 21:54:54'),
(106, 37, 228, 'C', 1, '2025-09-01 21:54:54'),
(107, 37, 237, 'C', 1, '2025-09-01 21:54:54'),
(108, 37, 241, 'C', 0, '2025-09-01 21:54:54'),
(109, 51, 188, 'C', 1, '2025-09-02 00:14:55'),
(110, 51, 196, 'D', 1, '2025-09-02 00:14:55'),
(111, 51, 199, 'C', 0, '2025-09-02 00:14:55'),
(112, 51, 202, 'D', 0, '2025-09-02 00:14:55'),
(113, 51, 221, 'D', 0, '2025-09-02 00:14:55'),
(114, 51, 222, 'B', 0, '2025-09-02 00:14:55'),
(115, 51, 225, 'A', 0, '2025-09-02 00:14:55'),
(116, 51, 228, 'A', 0, '2025-09-02 00:14:55'),
(117, 51, 237, 'B', 0, '2025-09-02 00:14:55'),
(118, 51, 241, 'C', 0, '2025-09-02 00:14:55'),
(119, 52, 188, 'A', 0, '2025-09-02 00:16:04'),
(120, 52, 196, 'C', 0, '2025-09-02 00:16:04'),
(121, 52, 199, 'D', 0, '2025-09-02 00:16:04'),
(122, 52, 202, 'C', 0, '2025-09-02 00:16:04'),
(123, 52, 221, 'B', 1, '2025-09-02 00:16:04'),
(124, 52, 222, 'B', 0, '2025-09-02 00:16:04'),
(125, 52, 225, 'A', 0, '2025-09-02 00:16:04'),
(126, 52, 228, 'A', 0, '2025-09-02 00:16:04'),
(127, 52, 237, 'A', 0, '2025-09-02 00:16:04'),
(128, 52, 241, 'D', 0, '2025-09-02 00:16:04'),
(129, 53, 188, 'C', 1, '2025-09-02 00:19:34'),
(130, 53, 196, 'B', 0, '2025-09-02 00:19:34'),
(131, 53, 199, 'B', 0, '2025-09-02 00:19:34'),
(132, 53, 202, 'D', 0, '2025-09-02 00:19:34'),
(133, 53, 221, 'A', 0, '2025-09-02 00:19:34'),
(134, 53, 222, 'D', 0, '2025-09-02 00:19:34'),
(135, 53, 225, 'A', 0, '2025-09-02 00:19:34'),
(136, 53, 228, 'C', 1, '2025-09-02 00:19:34'),
(137, 53, 237, 'C', 1, '2025-09-02 00:19:34'),
(138, 53, 241, 'B', 1, '2025-09-02 00:19:34'),
(139, 54, 188, 'C', 1, '2025-09-02 00:20:56'),
(140, 54, 196, 'A', 0, '2025-09-02 00:20:56'),
(141, 54, 199, 'D', 0, '2025-09-02 00:20:56'),
(142, 54, 202, 'D', 0, '2025-09-02 00:20:56'),
(143, 54, 221, 'A', 0, '2025-09-02 00:20:56'),
(144, 54, 222, 'D', 0, '2025-09-02 00:20:56'),
(145, 54, 225, 'B', 0, '2025-09-02 00:20:56'),
(146, 54, 228, 'B', 0, '2025-09-02 00:20:56'),
(147, 54, 237, 'B', 0, '2025-09-02 00:20:56'),
(148, 54, 241, 'C', 0, '2025-09-02 00:20:56'),
(149, 55, 188, 'D', 0, '2025-09-02 00:21:59'),
(150, 55, 196, 'B', 0, '2025-09-02 00:21:59'),
(151, 55, 199, 'D', 0, '2025-09-02 00:21:59'),
(152, 55, 202, 'B', 0, '2025-09-02 00:21:59'),
(153, 55, 221, 'B', 1, '2025-09-02 00:21:59'),
(154, 55, 222, 'C', 0, '2025-09-02 00:21:59'),
(155, 55, 225, 'B', 0, '2025-09-02 00:21:59'),
(156, 55, 228, 'D', 0, '2025-09-02 00:21:59'),
(157, 55, 237, 'C', 1, '2025-09-02 00:21:59'),
(158, 55, 241, 'C', 0, '2025-09-02 00:21:59'),
(159, 56, 82, 'B', 0, '2025-09-02 12:00:27'),
(160, 56, 87, 'C', 0, '2025-09-02 12:00:27'),
(161, 56, 105, 'C', 0, '2025-09-02 12:00:27'),
(162, 56, 116, 'A', 0, '2025-09-02 12:00:27'),
(163, 56, 145, 'B', 1, '2025-09-02 12:00:27'),
(164, 56, 150, 'B', 0, '2025-09-02 12:00:27'),
(165, 56, 151, 'C', 0, '2025-09-02 12:00:27'),
(166, 56, 152, 'B', 1, '2025-09-02 12:00:27'),
(167, 56, 164, 'D', 0, '2025-09-02 12:00:27'),
(168, 56, 180, 'C', 0, '2025-09-02 12:00:27'),
(169, 57, 84, 'D', 0, '2025-09-02 12:28:36'),
(170, 57, 103, 'A', 0, '2025-09-02 12:28:36'),
(171, 57, 119, 'D', 1, '2025-09-02 12:28:36'),
(172, 57, 126, 'B', 0, '2025-09-02 12:28:36'),
(173, 57, 129, 'D', 0, '2025-09-02 12:28:36'),
(174, 57, 135, 'D', 0, '2025-09-02 12:28:36'),
(175, 57, 152, 'C', 0, '2025-09-02 12:28:36'),
(176, 57, 164, 'C', 0, '2025-09-02 12:28:36'),
(177, 57, 167, 'A', 0, '2025-09-02 12:28:36'),
(178, 57, 184, 'D', 1, '2025-09-02 12:28:36'),
(179, 58, 84, 'B', 0, '2025-09-02 12:50:26'),
(180, 58, 103, 'D', 0, '2025-09-02 12:50:26'),
(181, 58, 119, 'C', 0, '2025-09-02 12:50:26'),
(182, 58, 126, 'C', 0, '2025-09-02 12:50:26'),
(183, 58, 129, 'B', 1, '2025-09-02 12:50:26'),
(184, 58, 135, 'B', 1, '2025-09-02 12:50:26'),
(185, 58, 152, 'B', 1, '2025-09-02 12:50:26'),
(186, 58, 164, 'D', 0, '2025-09-02 12:50:26'),
(187, 58, 167, 'A', 0, '2025-09-02 12:50:26'),
(188, 58, 184, 'C', 0, '2025-09-02 12:50:26'),
(189, 59, 84, 'B', 0, '2025-09-02 15:34:50'),
(190, 59, 103, 'B', 1, '2025-09-02 15:34:50'),
(191, 59, 119, 'B', 0, '2025-09-02 15:34:50'),
(192, 59, 126, 'A', 0, '2025-09-02 15:34:50'),
(193, 59, 129, 'B', 1, '2025-09-02 15:34:50'),
(194, 59, 135, 'B', 1, '2025-09-02 15:34:50'),
(195, 59, 152, 'A', 0, '2025-09-02 15:34:50'),
(196, 59, 164, 'D', 0, '2025-09-02 15:34:50'),
(197, 59, 167, 'A', 0, '2025-09-02 15:34:50'),
(198, 59, 184, 'B', 0, '2025-09-02 15:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `student_tests`
--

CREATE TABLE `student_tests` (
  `student_test_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `start_time` datetime DEFAULT current_timestamp(),
  `end_time` datetime DEFAULT NULL,
  `score` decimal(5,2) DEFAULT 0.00,
  `status` enum('started','completed') DEFAULT 'started'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_tests`
--

INSERT INTO `student_tests` (`student_test_id`, `student_id`, `test_id`, `start_time`, `end_time`, `score`, `status`) VALUES
(1, 1, 1, '2025-08-24 22:39:39', '2025-08-25 09:42:10', 2.00, 'completed'),
(2, 1, 1, '2025-08-24 22:39:39', NULL, 3.00, 'started'),
(3, 1, 1, '2025-08-24 22:39:40', NULL, 3.00, 'started'),
(4, 1, 1, '2025-08-24 22:39:40', NULL, 3.00, 'started'),
(5, 1, 1, '2025-08-24 22:39:41', NULL, 3.00, 'started'),
(6, 1, 1, '2025-08-24 22:43:21', NULL, 3.00, 'started'),
(7, 1, 1, '2025-08-24 22:44:54', NULL, 3.00, 'started'),
(8, 1, 1, '2025-08-24 22:46:10', NULL, 3.00, 'started'),
(9, 1, 1, '2025-08-24 22:49:29', NULL, 3.00, 'started'),
(10, 1, 1, '2025-08-24 22:55:30', NULL, 3.00, 'started'),
(11, 1, 1, '2025-08-24 22:55:58', NULL, 3.00, 'started'),
(12, 1, 1, '2025-08-24 22:56:09', NULL, 3.00, 'started'),
(13, 1, 1, '2025-08-24 22:56:20', NULL, 3.00, 'started'),
(14, 1, 1, '2025-08-24 22:56:37', NULL, 3.00, 'started'),
(15, 1, 1, '2025-08-24 22:58:50', NULL, 3.00, 'started'),
(16, 1, 1, '2025-08-24 23:05:11', NULL, 3.00, 'started'),
(17, 1, 1, '2025-08-24 23:05:22', NULL, 3.00, 'started'),
(18, 1, 1, '2025-08-24 23:08:40', NULL, 3.00, 'started'),
(19, 1, 1, '2025-08-24 23:09:00', NULL, 3.00, 'started'),
(20, 1, 1, '2025-08-24 23:09:09', NULL, 3.00, 'started'),
(21, 1, 1, '2025-08-24 23:09:14', NULL, 3.00, 'started'),
(22, 1, 1, '2025-08-24 23:10:11', NULL, 3.00, 'started'),
(23, 1, 1, '2025-08-24 23:10:34', NULL, 3.00, 'started'),
(24, 1, 1, '2025-08-25 05:30:57', NULL, 3.00, 'started'),
(25, 1, 1, '2025-08-25 05:47:52', NULL, 3.00, 'started'),
(26, 1, 1, '2025-08-25 05:49:08', NULL, 3.00, 'started'),
(27, 1, 1, '2025-08-25 05:49:43', NULL, 3.00, 'started'),
(28, 1, 1, '2025-08-25 05:50:14', NULL, 3.00, 'started'),
(29, 1, 1, '2025-08-25 05:58:18', NULL, 3.00, 'started'),
(30, 1, 1, '2025-08-25 06:00:40', NULL, 3.00, 'started'),
(31, 1, 1, '2025-08-25 06:01:55', NULL, 0.00, 'started'),
(32, 1, 1, '2025-08-25 06:29:20', NULL, 0.00, 'started'),
(33, 1, 1, '2025-08-25 06:37:06', NULL, 0.00, 'started'),
(34, 1, 1, '2025-08-25 06:37:29', NULL, 0.00, 'started'),
(35, 1, 1, '2025-08-25 09:42:02', NULL, 0.00, 'started'),
(36, 1, 1, '2025-08-25 09:49:56', NULL, 0.00, 'started'),
(37, 1, 8, '2025-09-01 15:50:59', '2025-09-01 21:54:54', 3.00, 'completed'),
(38, 1, 8, '2025-09-01 15:54:16', NULL, 0.00, 'started'),
(39, 1, 8, '2025-09-01 15:58:33', NULL, 0.00, 'started'),
(40, 1, 8, '2025-09-01 16:18:13', NULL, 0.00, 'started'),
(41, 1, 8, '2025-09-01 16:21:42', NULL, 0.00, 'started'),
(42, 1, 8, '2025-09-01 16:33:07', NULL, 0.00, 'started'),
(43, 1, 8, '2025-09-01 16:34:31', NULL, 0.00, 'started'),
(44, 1, 8, '2025-09-01 16:35:55', NULL, 0.00, 'started'),
(45, 1, 8, '2025-09-01 16:37:01', NULL, 0.00, 'started'),
(46, 1, 8, '2025-09-01 16:37:51', NULL, 0.00, 'started'),
(47, 1, 8, '2025-09-01 16:42:20', NULL, 0.00, 'started'),
(48, 1, 8, '2025-09-01 19:58:15', NULL, 0.00, 'started'),
(49, 1, 7, '2025-09-01 21:11:29', NULL, 0.00, 'started'),
(50, 1, 8, '2025-09-01 21:54:33', NULL, 0.00, 'started'),
(51, 4, 8, '2025-09-02 00:14:39', '2025-09-02 00:14:55', 2.00, 'completed'),
(52, 5, 8, '2025-09-02 00:15:45', '2025-09-02 00:16:04', 1.00, 'completed'),
(53, 6, 8, '2025-09-02 00:19:10', '2025-09-02 00:19:34', 4.00, 'completed'),
(54, 7, 8, '2025-09-02 00:20:30', '2025-09-02 00:20:56', 1.00, 'completed'),
(55, 8, 8, '2025-09-02 00:21:40', '2025-09-02 00:21:59', 2.00, 'completed'),
(56, 127, 6, '2025-09-02 12:00:13', '2025-09-02 12:00:27', 2.00, 'completed'),
(57, 189, 9, '2025-09-02 12:28:02', '2025-09-02 12:28:36', 2.00, 'completed'),
(58, 197, 9, '2025-09-02 12:49:04', '2025-09-02 12:50:26', 3.00, 'completed'),
(59, 1, 9, '2025-09-02 14:58:23', '2025-09-02 15:34:50', 3.00, 'completed'),
(60, 1, 9, '2025-09-02 15:09:01', NULL, 0.00, 'started'),
(61, 1, 9, '2025-09-02 15:33:44', NULL, 0.00, 'started');

-- --------------------------------------------------------

--
-- Table structure for table `sub_topics`
--

CREATE TABLE `sub_topics` (
  `sub_topic_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `by_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_topics`
--

INSERT INTO `sub_topics` (`sub_topic_id`, `topic_id`, `title`, `description`, `added_by`, `by_admin`, `created_at`, `updated_at`) VALUES
(1, 1, 'Variables & Data Types', 'Understanding variables and types', 1, 0, '2025-08-20 10:57:44', '2025-08-20 15:56:39'),
(2, 1, 'Control Structures', 'If, loops, and switch statements', 1, 0, '2025-08-20 10:57:44', '2025-08-20 10:57:44'),
(3, 7, 'in fully oops', 'oops based', 1, 0, '2025-08-20 16:20:53', '2025-08-20 16:21:20'),
(4, 4, 'we', 'we', NULL, 1, '2025-08-20 16:29:04', '2025-08-25 02:20:46'),
(5, 3, 'new', 'new', 2, 0, '2025-08-24 12:03:40', '2025-08-24 12:03:40'),
(6, 3, 'new', 'new', 2, 0, '2025-08-24 12:04:22', '2025-08-24 12:04:22'),
(7, 3, 'new', 'new', 2, 0, '2025-08-24 12:04:28', '2025-08-24 12:04:28'),
(8, 11, 'new another', '', 2, 0, '2025-08-24 12:04:52', '2025-08-24 12:17:13'),
(9, 12, 'Variables', 'variable based problems', 2, 0, '2025-09-01 07:17:01', '2025-09-01 09:35:35'),
(10, 12, 'testing', 'just a test', 2, 0, '2025-09-01 09:40:52', '2025-09-01 09:40:52'),
(11, 13, 'testing', 'testing topic', 2, 0, '2025-09-03 09:15:35', '2025-09-03 09:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `test_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `sub_topic_id` int(11) DEFAULT NULL,
  `num_questions` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time_slot` varchar(100) DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`test_id`, `title`, `description`, `subject`, `added_by`, `topic_id`, `sub_topic_id`, `num_questions`, `department_id`, `year`, `date`, `time_slot`, `duration_minutes`, `created_at`, `is_active`) VALUES
(1, 'test', 'its new one', 'new', 2, 11, 1, 90, 1, 1, '2025-08-24', 'morning', 90, '2025-08-24 13:07:49', 1),
(2, 'Testing nscet', 'Simple Test', 'C Program', 2, 12, 10, 10, 7, 2, '2025-09-01', '0', 20, '2025-09-01 09:46:54', 1),
(6, 'Testing', 'Testing test', 'C Program', 2, 12, 9, 10, 6, 1, '2025-09-01', '0', 10, '2025-09-01 10:16:13', 1),
(7, 'Variable testing', 'Alpha Testing', 'C Program', 2, 12, 10, 10, 1, 6, '2025-09-01', '0', 10, '2025-09-01 10:18:58', 1),
(8, 'asdfas', 'aszaaaaaaaaaaaaaaa', 'asdfdsdasd', 2, 12, 10, 10, 1, 1, '2025-09-01', '0', 10, '2025-09-01 10:19:59', 1),
(9, 'Pointers', 'Test for summa', 'C language', 2, 12, 9, 10, 1, 1, '2025-09-04', '0', 30, '2025-09-02 06:57:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `test_questions`
--

CREATE TABLE `test_questions` (
  `test_question_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `test_questions`
--

INSERT INTO `test_questions` (`test_question_id`, `test_id`, `question_id`, `created_at`) VALUES
(31, 6, 87, '2025-09-01 10:16:13'),
(32, 6, 164, '2025-09-01 10:16:13'),
(33, 6, 152, '2025-09-01 10:16:13'),
(34, 6, 145, '2025-09-01 10:16:13'),
(35, 6, 82, '2025-09-01 10:16:13'),
(36, 6, 151, '2025-09-01 10:16:13'),
(37, 6, 105, '2025-09-01 10:16:13'),
(38, 6, 180, '2025-09-01 10:16:13'),
(39, 6, 150, '2025-09-01 10:16:13'),
(40, 6, 116, '2025-09-01 10:16:13'),
(41, 7, 232, '2025-09-01 10:18:58'),
(42, 7, 208, '2025-09-01 10:18:58'),
(43, 7, 240, '2025-09-01 10:18:58'),
(44, 7, 191, '2025-09-01 10:18:58'),
(45, 7, 188, '2025-09-01 10:18:58'),
(46, 7, 218, '2025-09-01 10:18:58'),
(47, 7, 195, '2025-09-01 10:18:58'),
(48, 7, 197, '2025-09-01 10:18:58'),
(49, 7, 221, '2025-09-01 10:18:58'),
(50, 7, 200, '2025-09-01 10:18:58'),
(51, 8, 196, '2025-09-01 10:19:59'),
(52, 8, 222, '2025-09-01 10:19:59'),
(53, 8, 225, '2025-09-01 10:19:59'),
(54, 8, 237, '2025-09-01 10:19:59'),
(55, 8, 228, '2025-09-01 10:19:59'),
(56, 8, 188, '2025-09-01 10:19:59'),
(57, 8, 241, '2025-09-01 10:19:59'),
(58, 8, 199, '2025-09-01 10:19:59'),
(59, 8, 221, '2025-09-01 10:19:59'),
(60, 8, 202, '2025-09-01 10:19:59'),
(61, 9, 103, '2025-09-02 06:57:21'),
(62, 9, 84, '2025-09-02 06:57:21'),
(63, 9, 119, '2025-09-02 06:57:21'),
(64, 9, 129, '2025-09-02 06:57:21'),
(65, 9, 164, '2025-09-02 06:57:21'),
(66, 9, 135, '2025-09-02 06:57:21'),
(67, 9, 126, '2025-09-02 06:57:21'),
(68, 9, 152, '2025-09-02 06:57:21'),
(69, 9, 184, '2025-09-02 06:57:21'),
(70, 9, 167, '2025-09-02 06:57:21');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `by_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `title`, `description`, `added_by`, `by_admin`, `created_at`, `updated_at`) VALUES
(1, 'Python', 'its test', 1, 0, '2025-08-19 07:46:38', '2025-08-20 15:49:19'),
(2, 'python 2', 'its test', 1, 0, '2025-08-19 07:46:38', '2025-08-20 15:49:17'),
(3, 'python 2', 'its test', NULL, 1, '2025-08-19 07:46:38', '2025-08-20 01:11:13'),
(4, 'another', 'its test', 2, 0, '2025-08-19 07:46:38', '2025-08-20 16:23:24'),
(5, 'python 2', 'its test', NULL, 1, '2025-08-19 07:46:38', '2025-08-20 01:11:13'),
(6, 'Programming Basics', 'Covers intro programming concepts', 1, 0, '2025-08-20 10:57:44', '2025-08-20 15:49:22'),
(7, 'java', 'its java', 1, 0, '2025-08-20 15:47:12', '2025-08-20 15:48:57'),
(8, 'Programming in C', 'Its programmer', 1, 0, '2025-08-20 16:08:26', '2025-08-20 16:08:26'),
(9, 'mark', 'mark', 1, 0, '2025-08-20 16:09:56', '2025-08-20 16:09:56'),
(10, 'new', 'new', NULL, 0, '2025-08-24 11:46:40', '2025-08-24 11:46:40'),
(11, 'new topic', 'new topic', 2, 0, '2025-08-24 11:47:08', '2025-08-24 11:47:08'),
(12, 'C programming', 'This is the c Programming', 2, 0, '2025-09-01 07:16:40', '2025-09-01 07:16:40'),
(13, 'Python', 'test for python', 2, 0, '2025-09-03 09:15:20', '2025-09-03 09:15:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `roll_no` text NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `roll_no`, `name`, `email`, `password`, `year`, `role_id`, `department_id`, `created_at`, `updated_at`) VALUES
(1, '9210', 'Santhodh', 'santhosh@gmail.com', '$2y$10$LfSoN7gNH6rM1BGbHTJYIecWsyM9xdrSUee36798vpVasPiVWhPGq', 1, 1, 1, '2025-08-18 06:16:30', '2025-09-01 15:42:28'),
(2, '123', 'Vinoth kumar', 'vinoth@gmail.com', '$2y$10$uG1DU4p/TebrPy4SjhBex.7HCU7nvcPpqQo0X5TpZFe79XagwHhEO', 0, 2, 1, '2025-08-18 06:16:30', '2025-09-02 05:14:01'),
(4, '92101', 'Sachin', 'sachin@gmail.com', '$2y$10$MoQhb/od10hWGhAgIEOvEefNXfUxONDDStEhUxXVVQN6w.G1txrsS', 1, 1, 6, '2025-09-01 18:43:16', '2025-09-02 05:20:00'),
(5, '92102', 'Sri Hari', 'srihari@gmail.com', '$2y$10$s2DyUDA9aAq7BXlCEgtxaOb5SIh/nVSL4sYd3imsj1KUqbOzSuc9m', 1, 1, 6, '2025-09-01 18:43:16', '2025-09-02 05:20:05'),
(6, '92103', 'Aaswin', 'aaswin@gmail.com', '$2y$10$6htwx/PnIeSERFScDip9Vuy61vQk55SMFrl.NQ4ECDqa.zcqRrv6O', 1, 1, 1, '2025-09-01 18:43:16', '2025-09-01 18:48:54'),
(7, '92104', 'Keerthana', 'keerthana@gmail.com', '$2y$10$kra/d5Cp8zYwRjS1pKakKOLD5/E5Wu6/ASljxAMZBB3Nm./41pXG.', 1, 1, 1, '2025-09-01 18:43:16', '2025-09-01 18:50:17'),
(8, '92105', 'archana', 'archana@gmail.com', '$2y$10$2B16AIhHiblKffYgt9M24ecbA/pPEr3xp3jKKkgpgBWIu5y2cZaUq', 1, 2, 6, '2025-09-01 18:43:16', '2025-09-02 05:25:29'),
(112, '921022243001', 'AJAY M', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(113, '921022243002', 'AJAY S', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(114, '921022243003', 'AKSHAYA K', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(115, '921022243004', 'BALA MAHALAKSHMI S', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(116, '921022243005', 'DHEIVASHRI M', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(117, '921022243008', 'ISHANI P', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(118, '921022243009', 'JAYA GOKUL M', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(119, '921022243010', 'KARAN S', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(120, '921022243011', 'KEERTHANA T', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(121, '921022243012', 'NAVEEN KUMAR S', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(122, '921022243013', 'NITHEESH PATRICK P', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(123, '921022243014', 'PARI VIGNESH D S', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(124, '921022243015', 'PRANAV S', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(125, '921022243016', 'RAJAVARSHINI C', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(126, '921022243018', 'SHAFANA IRFATH N', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(127, '921022243019', 'SHAFEEK MURATH S', NULL, '$2y$10$f/mouCZzSSkV557vorvMHOqgpKZ8czNCM7c3gt7Faftaj2gscyLEy', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:28:02'),
(128, '921022243020', 'SHOBIKA SHREE N', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(129, '921022243021', 'SHRI HARINI S', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(130, '921022243022', 'SRIDEVI B', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(131, '921022243023', 'VISHWAROOBINI N', NULL, '', 1, 1, 6, '2025-09-02 06:26:57', '2025-09-02 06:26:57'),
(132, '921022205001', 'AASWIN J S', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(133, '921022205002', 'ABI GAYATHRI P', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(134, '921022205003', 'ABINAYA P', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(135, '921022205005', 'GOWSIK P', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(136, '921022205006', 'MOHAMED IRFAN SHEIK K', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(137, '921022205007', 'NAAFIYA SHIRIN A', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(138, '921022205008', 'NAGAJOTHI M', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(139, '921022205009', 'NANDHINI S', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(140, '921022205010', 'NATHIYA P', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(141, '921022205011', 'NAVEEN BHARATHI B', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(142, '921022205012', 'NIHILAA K', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(143, '921022205013', 'PARAMESHWAR N S', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(144, '921022205014', 'PRAVIN K', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(145, '921022205015', 'PREETHI V', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(146, '921022205016', 'RAMYA PRIYA J', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(147, '921022205017', 'RANA SUSMITHA R', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(148, '921022205018', 'SARVAJI M', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(149, '921022205019', 'SATHYA SEELAN M', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(150, '921022205020', 'SIVASRI V', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(151, '921022205021', 'SRIHARI PRASATH A', NULL, '$2y$10$eLfLP/IvvTOxmrR0RHlKSO4jtTkbz5VQ79XD.GlJ94hSyhrHYa1fi', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(152, '921022205022', 'SURYAPRAKASH A', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(153, '921022205023', 'SWATHI P', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(154, '921022205024', 'VIGNESWAR S', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(155, '921022205025', 'YAMINI S', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(156, '921022205026', 'YOHITHKUMAR R', NULL, '', 1, 1, 7, '2025-09-02 06:36:40', '2025-09-02 06:52:23'),
(157, '921022104001', 'AARTHI S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(158, '921022104002', 'ABARNA A', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(159, '921022104003', 'AKILAN A', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(160, '921022104004', 'AKSHAYA N S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(161, '921022104005', 'ANANDHITHA GAYATHIRI A', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(162, '921022104006', 'ANKAYARKANNI M', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(163, '921022104007', 'ARCHANA A', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(164, '921022104008', 'BHARATH SURYA M', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(165, '921022104009', 'CHANDISH S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(166, '921022104010', 'DHANUSH D', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(167, '921022104011', 'FARHANA BANU K', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(168, '921022104012', 'FEMILA M', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(169, '921022104013', 'GOKULNATH B', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(170, '921022104014', 'GOWRI M', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(171, '921022104015', 'HARINI G', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(172, '921022104016', 'HARINI J', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(173, '921022104017', 'JEYASRI C', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(174, '921022104018', 'KALA DEVI S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(175, '921022104019', 'KALAI SELVI M', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(176, '921022104020', 'KARUNYA JOTHIKA S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(177, '921022104021', 'KAVIYASHREE B', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(178, '921022104022', 'KIRUTHIKA G (07.09.2004)', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(179, '921022104023', 'KIRUTHIKA M (18.11.2004)', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(180, '921022104024', 'KUZHALI E', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(181, '921022104025', 'LALITHAMBIHAI R G', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(182, '921022104026', 'MADHUBALA S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(183, '921022104027', 'MAHMOOD SHAFI K', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(184, '921022104028', 'MATHAN M', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(185, '921022104029', 'MIRUTHYUNJAY J A', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(186, '921022104030', 'MONISHA C', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(187, '921022104031', 'NANTHIDHA S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(188, '921022104032', 'NITHISH V', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(189, '921022104033', ' JOSHIKA', NULL, '$2y$10$4hSAB8y7HlXR2bXrjH2xNOrhfa9UxtN0U.u4YoGxxbE6dDbxLGfJy', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 07:00:32'),
(190, '921022104034', 'POOJA T', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(191, '921022104035', 'PRIYANKA M', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(192, '921022104036', 'PUNITHA B', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(193, '921022104037', 'RAMSANJEEV R', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(194, '921022104038', 'RAVINTHAR A', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(195, '921022104039', 'RESHMA SHREE L V', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(196, '921022104040', 'RITHISH V', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(197, '921022104041', 'SACHITHANANDAN S', NULL, '$2y$10$5pGYAjB2QWsosaFbd6iAw.CeTikSXB8dkZWbPDBKKN1SYtGlBYgvq', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 07:18:44'),
(198, '921022104042', 'SHIVANIHA J', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(199, '921022104043', 'SIMRITHA SRI V', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(200, '921022104044', 'SIVA PANDI V', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(201, '921022104045', 'SONIYA N', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(202, '921022104046', 'SRI NATHI S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(203, '921022104047', 'SRISAKTHI S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(204, '921022104048', 'SUBIKSHA M', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(205, '921022104049', 'SUBIKSHAA S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(206, '921022104050', 'SUJITHRA V', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(207, '921022104051', 'SURUTHI PRATHAP S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(208, '921022104052', 'SUSMITHA S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(209, '921022104053', 'SWATHI K', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(210, '921022104054', 'THAVASAKTHI G', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(211, '921022104055', 'VARSHINI K', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(212, '921022104056', 'VIJAY AKASH M', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(213, '921022104057', 'VIJITHRA V', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(214, '921022104058', 'VINYAA SREE P G', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(215, '921022104059', 'YOGESHWARAN M', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(216, '921022104060', 'YUGESH KUMAR A', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(217, '921022104701', 'MOHAMED JAMEES K', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(218, '921022104702', 'SAKTHI PANDEESWARI S', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23'),
(219, '921022104703', 'UMA MAHESWARI B', NULL, '', 1, 1, 1, '2025-09-02 06:46:45', '2025-09-02 06:52:23');

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
  ADD KEY `fk_questions_subtopic` (`sub_topic_id`),
  ADD KEY `fk_questions_faculty` (`created_by`);

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
  ADD KEY `fk_topic` (`topic_id`),
  ADD KEY `fk_subtopic_added_by` (`added_by`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`test_id`),
  ADD KEY `fk_tests_department` (`department_id`),
  ADD KEY `fk_tests_topic` (`topic_id`),
  ADD KEY `fk_tests_subtopic` (`sub_topic_id`),
  ADD KEY `fk_tests_user` (`added_by`);

--
-- Indexes for table `test_questions`
--
ALTER TABLE `test_questions`
  ADD PRIMARY KEY (`test_question_id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `fk_added_by` (`added_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `roll_no` (`roll_no`) USING HASH,
  ADD KEY `fk_role` (`role_id`),
  ADD KEY `fk_department` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analytics`
--
ALTER TABLE `analytics`
  MODIFY `analytics_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `leaderboard_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_answers`
--
ALTER TABLE `student_answers`
  MODIFY `student_answers_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `student_tests`
--
ALTER TABLE `student_tests`
  MODIFY `student_test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `sub_topics`
--
ALTER TABLE `sub_topics`
  MODIFY `sub_topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `test_questions`
--
ALTER TABLE `test_questions`
  MODIFY `test_question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `analytics`
--
ALTER TABLE `analytics`
  ADD CONSTRAINT `fk_analytics_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_analytics_test` FOREIGN KEY (`test_id`) REFERENCES `tests` (`test_id`);

--
-- Constraints for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD CONSTRAINT `fk_leaderboard_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_questions_faculty` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_questions_subtopic` FOREIGN KEY (`sub_topic_id`) REFERENCES `sub_topics` (`sub_topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
