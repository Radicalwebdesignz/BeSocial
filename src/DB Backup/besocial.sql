-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2018 at 10:43 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `besocial`
--

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `user_to` varchar(100) NOT NULL,
  `user_from` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `user_to`, `user_from`) VALUES
(2, 'max_smith', 'mike_meyer');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `post_id`) VALUES
(5, 'mike_meyer', 116),
(17, 'mike_meyer', 115),
(18, 'mike_meyer', 113),
(19, 'mike_meyer', 112),
(30, 'mike_meyer', 110),
(31, 'mike_meyer', 119),
(32, 'mike_meyer', 118),
(33, 'mike_meyer', 42),
(34, 'mike_meyer', 38),
(35, 'mike_meyer', 37),
(36, 'mike_meyer', 22),
(37, 'mike_meyer', 130),
(38, 'mike_meyer', 129),
(39, 'mike_meyer', 132),
(40, 'mike_meyer', 131),
(41, 'katie_rose', 112),
(42, 'mike_meyer', 147),
(43, 'mike_meyer', 133),
(44, 'john_dake', 23),
(45, 'john_dake', 22),
(46, 'mary_jane', 103),
(50, 'mike_meyer', 125),
(51, 'dave_klinger', 188),
(54, 'mike_meyer', 193),
(55, 'mike_meyer', 126),
(57, 'mike_meyer', 194),
(58, 'mike_meyer', 240),
(59, 'mike_meyer', 179),
(60, 'katie_rose', 23),
(61, 'katie_rose', 194),
(62, 'katie_rose', 22),
(63, 'katie_rose', 18),
(64, 'bob_simpson', 179),
(65, 'bob_simpson', 23),
(66, 'mike_meyer', 23),
(67, 'mike_meyer', 127),
(68, 'mike_meyer_1', 247);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_to` varchar(100) NOT NULL,
  `user_from` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_to`, `user_from`, `body`, `date`, `opened`, `viewed`, `deleted`) VALUES
(22, 'bob_simpson', 'mike_meyer', 'Hi Bob!!', '2018-01-10 21:20:18', 'yes', 'no', 'no'),
(23, 'bob_simpson', 'mike_meyer', 'How are you doing?', '2018-01-10 21:20:25', 'yes', 'no', 'no'),
(24, 'bob_simpson', 'mike_meyer', 'Whats Happening?', '2018-01-10 21:20:42', 'yes', 'no', 'no'),
(25, 'bob_simpson', 'mike_meyer', 'What you planning on doing this weekend?', '2018-01-10 21:20:54', 'yes', 'no', 'no'),
(26, 'bob_simpson', 'mike_meyer', 'I have some planes, if you dont have any.', '2018-01-10 21:21:10', 'yes', 'no', 'no'),
(27, 'bob_simpson', 'mike_meyer', 'Get back..', '2018-01-10 21:21:15', 'yes', 'no', 'no'),
(28, 'mike_meyer', 'bob_simpson', 'Hi Mike', '2018-01-10 22:12:50', 'yes', 'yes', 'no'),
(29, 'mike_meyer', 'bob_simpson', 'I am doing great. How about you?', '2018-01-10 22:13:09', 'yes', 'yes', 'no'),
(30, 'mike_meyer', 'bob_simpson', 'I have some plans. However, I am not sure about it. Is that alright if I let you know in few days?', '2018-01-10 22:14:11', 'yes', 'yes', 'no'),
(70, 'bob_simpson', 'mike_meyer', 'hi', '2018-01-11 12:35:07', 'yes', 'no', 'no'),
(71, 'john_dake', 'mike_meyer', 'howdy?', '2018-01-11 12:35:14', 'yes', 'no', 'no'),
(77, 'john_dake', 'mike_meyer', 'whats up??', '2018-01-11 12:39:06', 'yes', 'no', 'no'),
(84, 'katie_rose', 'mike_meyer', 'Hi Katie', '2018-01-11 13:28:13', 'yes', 'yes', 'no'),
(85, 'mike_meyer', 'katie_rose', 'Hello', '2018-01-11 13:48:56', 'yes', 'yes', 'no'),
(86, 'mike_meyer', 'katie_rose', 'Hi', '2018-01-11 15:17:12', 'yes', 'yes', 'no'),
(87, 'mike_meyer', 'katie_rose', 'hi', '2018-01-11 15:20:58', 'yes', 'yes', 'no'),
(88, 'mike_meyer', 'katie_rose', 'hi', '2018-01-11 15:31:11', 'yes', 'yes', 'no'),
(92, 'katie_rose', 'mike_meyer', 'hi', '2018-01-11 16:04:10', 'yes', 'yes', 'no'),
(93, 'katie_rose', 'mike_meyer', 'hru?', '2018-01-11 16:09:47', 'yes', 'yes', 'no'),
(94, 'katie_rose', 'mike_meyer', 'ok', '2018-01-11 16:09:53', 'yes', 'yes', 'no'),
(97, 'katie_rose', 'mike_meyer', 'Hi', '2018-01-11 18:19:05', 'yes', 'yes', 'no'),
(98, 'katie_rose', 'mike_meyer', 'ok', '2018-01-11 18:24:58', 'yes', 'yes', 'no'),
(99, 'katie_rose', 'mike_meyer', 'alright', '2018-01-11 18:25:10', 'yes', 'yes', 'no'),
(100, 'katie_rose', 'mike_meyer', 'fgfdgfsgdfg', '2018-01-11 18:26:52', 'yes', 'yes', 'no'),
(101, 'mike_meyer', 'katie_rose', 'Hi mike\r\n', '2018-01-11 19:47:54', 'yes', 'yes', 'no'),
(102, 'katie_rose', 'mike_meyer', 'Katie!!', '2018-01-11 21:20:26', 'yes', 'yes', 'no'),
(103, 'mike_meyer', 'mary_jane', 'Hi Mike', '2018-01-11 21:36:44', 'yes', 'yes', 'no'),
(104, 'mary_jane', 'mike_meyer', 'Hi', '2018-01-11 21:37:43', 'yes', 'no', 'no'),
(105, 'mike_meyer', 'mary_jane', 'Hi Mike', '2018-01-11 21:57:32', 'yes', 'yes', 'no'),
(106, 'john_dake', 'mike_meyer', 'hi', '2018-01-11 22:21:21', 'no', 'no', 'no'),
(107, 'mike_meyer', 'dave_klinger', 'Hola Mike', '2018-01-11 23:27:21', 'yes', 'yes', 'no'),
(108, 'mike_meyer', 'katie_rose', 'Ok', '2018-01-12 00:03:00', 'yes', 'yes', 'no'),
(109, 'mike_meyer', 'mary_jane', 'sdsd', '2018-01-12 00:06:57', 'yes', 'yes', 'no'),
(110, 'katie_rose', 'mary_jane', 'Hi', '2018-01-12 00:52:31', 'yes', 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_to` varchar(200) NOT NULL,
  `user_from` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(200) NOT NULL,
  `datetime` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_to`, `user_from`, `message`, `link`, `datetime`, `opened`, `viewed`) VALUES
(59, 'john_dake', 'mike_meyer', 'Mike Meyer liked your post', 'post.php?id=179', '2018-01-12 16:37:27', 'no', 'no'),
(60, 'john_dake', 'mike_meyer', 'Mike Meyer commented on your post', 'post.php?id=179', '2018-01-12 16:37:42', 'no', 'no'),
(61, 'katie_rose', 'mike_meyer', 'Mike Meyer commented on your profile post', 'post.php?id=240', '2018-01-12 16:38:11', 'yes', 'yes'),
(62, 'katie_rose', 'mike_meyer', 'Mike Meyer commented on your profile post', 'post.php?id=194', '2018-01-12 16:38:25', 'yes', 'yes'),
(63, 'mike_meyer', 'katie_rose', 'Katie Rose liked your post', 'post.php?id=23', '2018-01-12 17:16:06', 'yes', 'yes'),
(64, 'mike_meyer', 'katie_rose', 'Katie Rose commented on your post', 'post.php?id=22', '2018-01-12 17:16:14', 'no', 'yes'),
(65, 'mike_meyer', 'katie_rose', 'Katie Rose liked your post', 'post.php?id=194', '2018-01-12 17:44:24', 'no', 'yes'),
(66, 'mike_meyer', 'katie_rose', 'Katie Rose liked your post', 'post.php?id=22', '2018-01-12 17:44:29', 'no', 'yes'),
(67, 'mike_meyer', 'katie_rose', 'Katie Rose liked your post', 'post.php?id=18', '2018-01-12 17:44:31', 'yes', 'yes'),
(68, 'mike_meyer', 'katie_rose', 'Katie Rose commented on your post', 'post.php?id=20', '2018-01-12 17:44:40', 'no', 'yes'),
(69, 'john_dake', 'bob_simpson', 'Bob Simpson liked your post', 'post.php?id=179', '2018-01-12 17:46:49', 'no', 'no'),
(70, 'mike_meyer', 'bob_simpson', 'Bob Simpson liked your post', 'post.php?id=23', '2018-01-12 17:46:51', 'yes', 'yes'),
(71, 'mike_meyer', 'bob_simpson', 'Bob Simpson commented on your post', 'post.php?id=20', '2018-01-12 17:47:00', 'yes', 'yes'),
(72, 'katie_rose', 'bob_simpson', 'Bob Simpson commented on a post you commented on', 'post.php?id=20', '2018-01-12 17:47:00', 'yes', 'yes'),
(73, 'bob_simpson', 'mike_meyer', 'Mike Meyer liked your post', 'post.php?id=127', '2018-01-12 18:54:17', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `added_by` varchar(100) NOT NULL,
  `user_to` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `likes` int(11) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by`, `user_to`, `date_added`, `user_closed`, `deleted`, `likes`, `image`) VALUES
(18, 'Hi There!! Good AfterNoon...', 'mike_meyer', 'none', '2018-01-07 14:29:39', 'no', 'no', 1, ''),
(20, 'How you all doing?', 'mike_meyer', 'none', '2018-01-07 14:52:33', 'no', 'no', 0, ''),
(22, 'When one door of happiness closes, another opens; but often we look so long at the closed door that we do not see the one which has been opened for us.', 'mike_meyer', 'none', '2018-01-07 15:55:04', 'no', 'no', 3, ''),
(23, 'Twenty years from now you will be more disappointed by the things that you didnâ€™t do than by the ones you did do, so throw off the bowlines, sail away from safe harbor, catch the trade winds in your sails. Explore, Dream, Discover. â€”Mark Twain', 'mike_meyer', 'none', '2018-01-07 15:56:02', 'no', 'no', 4, ''),
(24, 'A person who never made a mistake never tried anything new.â€”â€”Albert Einstein', 'mary_jane', 'none', '2018-01-07 15:57:26', 'no', 'no', 0, ''),
(25, 'The only person you are destined to become is the person you decide to be. â€”Ralph Waldo Emerson', 'max_smith', 'none', '2018-01-07 15:58:28', 'no', 'no', 0, ''),
(26, 'Everything has beauty, but not everyone can see. â€”Confucius', 'max_smith', 'none', '2018-01-07 18:09:10', 'no', 'no', 0, ''),
(27, 'Certain things catch your eye, but pursue only those that capture the heart. â€”Ancient Indian Proverb', 'max_smith', 'none', '2018-01-07 18:09:20', 'no', 'no', 0, ''),
(28, 'I would rather die of passion than of boredom. â€”Vincent van Gogh', 'max_smith', 'none', '2018-01-07 18:09:36', 'no', 'no', 0, ''),
(29, 'The only way to do great work is to love what you do. â€”Steve Jobs', 'max_smith', 'none', '2018-01-07 18:09:44', 'no', 'no', 0, ''),
(30, 'The most difficult thing is the decision to act, the rest is merely tenacity. â€”Amelia Earhart', 'max_smith', 'none', '2018-01-07 18:10:11', 'no', 'no', 0, ''),
(31, 'I am not a product of my circumstances. I am a product of my decisions. â€”Stephen Covey', 'max_smith', 'none', '2018-01-07 18:10:18', 'no', 'no', 0, ''),
(32, 'Strive not to be a success, but rather to be of value. â€”Albert Einstein', 'max_smith', 'none', '2018-01-07 18:10:25', 'no', 'no', 0, ''),
(33, 'To handle yourself, use your head; to handle others, use your heart. â€”Eleanor Roosevelt', 'max_smith', 'none', '2018-01-07 18:10:32', 'no', 'no', 0, ''),
(34, 'Remember no one can make you feel inferior without your consent. â€”Eleanor Roosevelt', 'max_smith', 'none', '2018-01-07 18:10:39', 'no', 'no', 0, ''),
(35, 'Lovely Weather here today!!', 'max_smith', 'none', '2018-01-07 19:22:53', 'no', 'no', 0, ''),
(36, 'To live a creative life, we must lose our fear of being wrong. --Anonymous', 'katie_rose', 'none', '2018-01-08 11:56:36', 'no', 'no', 0, ''),
(37, 'If you want to achieve greatness stop asking for permission. --Anonymous', 'katie_rose', 'none', '2018-01-08 11:56:48', 'no', 'no', 1, ''),
(38, 'Things work out best for those who make the best of how things work out. --John Wooden', 'katie_rose', 'none', '2018-01-08 11:56:59', 'no', 'no', 1, ''),
(39, 'If you are not willing to risk the usual you will have to settle for the ordinary. --Jim Rohn', 'katie_rose', 'none', '2018-01-08 11:57:16', 'no', 'no', 0, ''),
(40, 'Trust because you are willing to accept the risk, not because it\'s safe or certain. --Anonymous', 'katie_rose', 'none', '2018-01-08 11:57:31', 'no', 'no', 0, ''),
(41, 'All our dreams can come true if we have the courage to pursue them. --Walt Disney', 'katie_rose', 'none', '2018-01-08 11:57:45', 'no', 'no', 0, ''),
(42, 'Good things come to people who wait, but better things come to those who go out and get them. --Anonymous', 'katie_rose', 'none', '2018-01-08 11:57:59', 'no', 'no', 1, ''),
(43, 'If you do what you always did, you will get what you always got. --Anonymous', 'mary_jane', 'none', '2018-01-08 11:58:49', 'no', 'no', 0, ''),
(44, 'Success is walking from failure to failure with no loss of enthusiasm. --Winston Churchill', 'mary_jane', 'none', '2018-01-08 11:58:57', 'no', 'no', 0, ''),
(45, 'ust when the caterpillar thought the world was ending, he turned into a butterfly. --Proverb', 'mary_jane', 'none', '2018-01-08 11:59:05', 'no', 'no', 0, ''),
(46, 'Opportunities don\'t happen, you create them. --Chris Grosser', 'mary_jane', 'none', '2018-01-08 11:59:16', 'no', 'no', 0, ''),
(47, 'Great minds discuss ideas; average minds discuss events; small minds discuss people. --Eleanor Roosevelt', 'mary_jane', 'none', '2018-01-08 11:59:25', 'no', 'no', 0, ''),
(48, 'I have not failed. I\'ve just found 10,000 ways that won\'t work. --Thomas A. Edison', 'mary_jane', 'none', '2018-01-08 11:59:37', 'no', 'no', 0, ''),
(49, 'If you don\'t value your time, neither will others. Stop giving away your time and talents--start charging for it. --Kim Garst', 'john_dake', 'none', '2018-01-08 12:00:17', 'no', 'no', 0, ''),
(50, 'A successful man is one who can lay a firm foundation with the bricks others have thrown at him. --David Brinkley', 'john_dake', 'none', '2018-01-08 12:00:25', 'no', 'no', 0, ''),
(51, 'No one can make you feel inferior without your consent. --Eleanor Roosevelt', 'john_dake', 'none', '2018-01-08 12:00:34', 'no', 'no', 0, ''),
(52, 'The whole secret of a successful life is to find out what is one\'s destiny to do, and then do it. --Henry Ford', 'john_dake', 'none', '2018-01-08 12:00:44', 'no', 'no', 0, ''),
(53, 'If you\'re going through hell keep going. --Winston Churchill', 'john_dake', 'none', '2018-01-08 12:00:54', 'no', 'no', 0, ''),
(54, 'The ones who are crazy enough to think they can change the world, are the ones who do. --Anonymous', 'john_dake', 'none', '2018-01-08 12:01:02', 'no', 'no', 0, ''),
(55, 'Don\'t raise your voice, improve your argument. --Anonymous', 'john_dake', 'none', '2018-01-08 12:01:09', 'no', 'no', 0, ''),
(56, 'What seems to us as bitter trials are often blessings in disguise. --Oscar Wilde', 'john_dake', 'none', '2018-01-08 12:01:17', 'no', 'no', 0, ''),
(57, 'The meaning of life is to find your gift. The purpose of life is to give it away. --Anonymous', 'john_dake', 'none', '2018-01-08 12:01:39', 'no', 'no', 0, ''),
(58, 'The distance between insanity and genius is measured only by success. --Bruce Feirstein', 'john_dake', 'none', '2018-01-08 12:01:46', 'no', 'no', 0, ''),
(59, 'When you stop chasing the wrong things, you give the right things a chance to catch you. --Lolly Daskal', 'john_dake', 'none', '2018-01-08 12:01:53', 'no', 'no', 0, ''),
(60, 'I believe that the only courage anybody ever needs is the courage to follow your own dreams. --Oprah Winfrey', 'john_dake', 'none', '2018-01-08 12:02:01', 'no', 'no', 0, ''),
(61, 'No masterpiece was ever created by a lazy artist. --Anonymous', 'john_dake', 'none', '2018-01-08 12:02:09', 'no', 'no', 0, ''),
(62, 'Happiness is a butterfly, which when pursued, is always beyond your grasp, but which, if you will sit down quietly, may alight upon you. --Nathaniel Hawthorne', 'john_dake', 'none', '2018-01-08 12:02:27', 'no', 'no', 0, ''),
(63, 'If you can\'t explain it simply, you don\'t understand it well enough. --Albert Einstein', 'john_dake', 'none', '2018-01-08 12:02:37', 'no', 'no', 0, ''),
(64, 'Blessed are those who can give without remembering and take without forgetting. --Anonymous', 'john_dake', 'none', '2018-01-08 12:02:47', 'no', 'no', 0, ''),
(65, 'Do one thing every day that scares you. --Anonymous', 'john_dake', 'none', '2018-01-08 12:02:54', 'no', 'no', 0, ''),
(66, 'What\'s the point of being alive if you don\'t at least try to do something remarkable. --Anonymous', 'john_dake', 'none', '2018-01-08 12:03:02', 'no', 'no', 0, ''),
(67, 'Nothing in the world is more common than unsuccessful people with talent. --Anonymous', 'john_dake', 'none', '2018-01-08 12:03:14', 'no', 'no', 0, ''),
(68, 'Knowledge is being aware of what you can do. Wisdom is knowing when not to do it. --Anonymous', 'dave_klinger', 'none', '2018-01-08 12:03:48', 'no', 'no', 0, ''),
(69, 'Your problem isn\'t the problem. Your reaction is the problem. --Anonymous', 'dave_klinger', 'none', '2018-01-08 12:03:57', 'no', 'no', 0, ''),
(70, 'You can do anything, but not everything. --Anonymous', 'dave_klinger', 'none', '2018-01-08 12:04:05', 'no', 'no', 0, ''),
(71, 'Innovation distinguishes between a leader and a follower. --Steve Jobs', 'dave_klinger', 'none', '2018-01-08 12:04:13', 'no', 'no', 0, ''),
(72, 'There are two types of people who will tell you that you cannot make a difference in this world: those who are afraid to try and those who are afraid you will succeed. --Ray Goforth', 'dave_klinger', 'none', '2018-01-08 12:04:21', 'no', 'no', 0, ''),
(73, 'Thinking should become your capital asset, no matter whatever ups and downs you come across in your life. --A.P.J. Abdul Kalam', 'dave_klinger', 'none', '2018-01-08 12:04:31', 'no', 'no', 0, ''),
(74, 'I find that the harder I work, the more luck I seem to have. --Thomas Jefferson', 'dave_klinger', 'none', '2018-01-08 12:04:39', 'no', 'no', 0, ''),
(75, 'The starting point of all achievement is desire. --Napoleon Hill', 'dave_klinger', 'none', '2018-01-08 12:04:46', 'no', 'no', 0, ''),
(76, 'Success is the sum of small efforts, repeated day-in and day-out. --Robert Collier', 'dave_klinger', 'none', '2018-01-08 12:04:54', 'no', 'no', 0, ''),
(77, 'If you want to achieve excellence, you can get there today. As of this second, quit doing less-than-excellent work. --Thomas J. Watson', 'dave_klinger', 'none', '2018-01-08 12:05:04', 'no', 'no', 0, ''),
(78, 'All progress takes place outside the comfort zone. --Michael John Bobak', 'dave_klinger', 'none', '2018-01-08 12:05:11', 'no', 'no', 0, ''),
(79, 'Courage is resistance to fear, mastery of fear--not absence of fear. --Mark Twain', 'dave_klinger', 'none', '2018-01-08 12:05:34', 'no', 'no', 0, ''),
(80, 'Only put off until tomorrow what you are willing to die having left undone. --Pablo Picasso', 'bob_simpson', 'none', '2018-01-08 12:06:00', 'no', 'no', 0, ''),
(81, 'People often say that motivation doesn\'t last. Well, neither does bathing--that\'s why we recommend it daily. --Zig Ziglar', 'bob_simpson', 'none', '2018-01-08 12:06:08', 'no', 'no', 0, ''),
(82, 'We become what we think about most of the time, and that\'s the strangest secret. --Earl Nightingale', 'bob_simpson', 'none', '2018-01-08 12:06:16', 'no', 'no', 0, ''),
(83, 'The only place where success comes before work is in the dictionary. --Vidal Sassoon', 'bob_simpson', 'none', '2018-01-08 12:06:24', 'no', 'no', 0, ''),
(84, 'Too many of us are not living our dreams because we are living our fears.\" --Les Brown', 'bob_simpson', 'none', '2018-01-08 12:06:33', 'no', 'no', 0, ''),
(85, 'I find that when you have a real interest in life and a curious life, that sleep is not the most important thing. --Martha Stewart', 'bob_simpson', 'none', '2018-01-08 12:06:51', 'no', 'no', 0, ''),
(86, 'It\'s not what you look at that matters, it\'s what you see. --Anonymous', 'bob_simpson', 'none', '2018-01-08 12:06:59', 'no', 'no', 0, ''),
(87, 'The road to success and the road to failure are almost exactly the same. --Colin R. Davis', 'bob_simpson', 'none', '2018-01-08 12:07:06', 'no', 'no', 0, ''),
(88, 'The function of leadership is to produce more leaders, not more followers. --Ralph Nader', 'bob_simpson', 'none', '2018-01-08 12:07:16', 'no', 'no', 0, ''),
(89, 'Success is liking yourself, liking what you do, and liking how you do it. --Maya Angelou', 'bob_simpson', 'none', '2018-01-08 12:07:23', 'no', 'no', 0, ''),
(90, 'As we look ahead into the next century, leaders will be those who empower others. --Bill Gates', 'bob_simpson', 'none', '2018-01-08 12:07:35', 'no', 'no', 0, ''),
(91, 'The first step toward success is taken when you refuse to be a captive of the environment in which you first find yourself. --Mark Caine', 'bob_simpson', 'none', '2018-01-08 12:07:50', 'no', 'no', 0, ''),
(92, 'People who succeed have momentum. The more they succeed, the more they want to succeed, and the more they find a way to succeed. Similarly, when someone is failing, the tendency is to get on a downward spiral that can even become a self-fulfilling prophecy. --Tony Robbins', 'bob_simpson', 'none', '2018-01-08 12:07:58', 'no', 'no', 0, ''),
(93, 'When I dare to be powerful, to use my strength in the service of my vision, then it becomes less and less important whether I am afraid. --Audre Lorde', 'bob_simpson', 'none', '2018-01-08 12:08:06', 'no', 'no', 0, ''),
(94, 'Whenever you find yourself on the side of the majority, it is time to pause and reflect. --Mark Twain', 'bob_simpson', 'none', '2018-01-08 12:08:13', 'no', 'no', 0, ''),
(95, 'The successful warrior is the average man, with laser-like focus. --Bruce Lee', 'mary_jane', 'none', '2018-01-08 12:08:33', 'no', 'no', 0, ''),
(96, 'There is no traffic jam along the extra mile. --Roger Staubach', 'mary_jane', 'none', '2018-01-08 12:08:40', 'no', 'no', 0, ''),
(97, 'Develop success from failures. Discouragement and failure are two of the surest stepping stones to success. --Dale Carnegie', 'mary_jane', 'none', '2018-01-08 12:08:46', 'no', 'no', 0, ''),
(98, 'If you don\'t design your own life plan, chances are you\'ll fall into someone else\'s plan. And guess what they have planned for you? Not much. --Jim Rohn', 'mary_jane', 'none', '2018-01-08 12:08:59', 'no', 'no', 0, ''),
(99, 'If you genuinely want something, don\'t wait for it--teach yourself to be impatient. --Gurbaksh Chahal', 'mary_jane', 'none', '2018-01-08 12:09:10', 'no', 'no', 0, ''),
(100, 'Don\'t let the fear of losing be greater than the excitement of winning. --Robert Kiyosaki', 'mary_jane', 'none', '2018-01-08 12:09:18', 'no', 'no', 0, ''),
(101, 'If you want to make a permanent change, stop focusing on the size of your problems and start focusing on the size of you! --T. Harv Eker', 'mary_jane', 'none', '2018-01-08 12:09:26', 'no', 'no', 0, ''),
(102, 'You can\'t connect the dots looking forward; you can only connect them looking backwards. So you have to trust that the dots will somehow connect in your future. You have to trust in something--your gut, destiny, life, karma, whatever. This approach has never let me down, and it has made all the difference in my life. --Steve Jobs', 'mary_jane', 'none', '2018-01-08 12:09:33', 'no', 'no', 0, ''),
(103, 'Two roads diverged in a wood and I  took the one less traveled by, and that made all the difference. --Robert Frost', 'mary_jane', 'none', '2018-01-08 12:09:41', 'no', 'no', 1, ''),
(104, 'The number one reason people fail in life is because they listen to their friends, family, and neighbors. --Napoleon Hill', 'max_smith', 'none', '2018-01-08 12:10:11', 'no', 'no', 0, ''),
(105, 'The reason most people never reach their goals is that they don\'t define them, or ever seriously consider them as believable or achievable. Winners can tell you where they are going, what they plan to do along the way, and who will be sharing the adventure with them. --Denis Waitley', 'max_smith', 'none', '2018-01-08 12:10:18', 'no', 'no', 0, ''),
(106, 'In my experience, there is only one motivation, and that is desire. No reasons or principle contain it or stand against it. --Jane Smiley', 'max_smith', 'none', '2018-01-08 12:10:28', 'no', 'no', 0, ''),
(107, 'Success does not consist in never making mistakes but in never making the same one a second time. --George Bernard Shaw', 'max_smith', 'none', '2018-01-08 12:10:36', 'no', 'no', 0, ''),
(108, 'I don\'t want to get to the end of my life and find that I lived just the length of it. I want to have lived the width of it as well. --Diane Ackerman', 'max_smith', 'none', '2018-01-08 12:10:43', 'no', 'no', 0, ''),
(109, 'You must expect great things of yourself before you can do them. --Michael Jordan', 'max_smith', 'none', '2018-01-08 12:10:51', 'no', 'no', 0, ''),
(110, 'Motivation is what gets you started. Habit is what keeps you going. --Jim Ryun', 'max_smith', 'none', '2018-01-08 12:10:58', 'no', 'no', 1, ''),
(111, 'People rarely succeed unless they have fun in what they are doing. --Dale Carnegie', 'katie_rose', 'none', '2018-01-08 12:11:20', 'no', 'no', 0, ''),
(112, 'There is no chance, no destiny, no fate, that can hinder or control the firm resolve of a determined soul. --Ella Wheeler Wilcox', 'katie_rose', 'none', '2018-01-08 12:11:27', 'no', 'no', 2, ''),
(113, 'Our greatest fear should not be of failure but of succeeding at things in life that don\'t really matter. --Francis Chan', 'katie_rose', 'none', '2018-01-08 12:11:33', 'no', 'no', 1, ''),
(114, 'You\'ve got to get up every morning with determination if you\'re going to go to bed with satisfaction. --George Lorimer', 'katie_rose', 'none', '2018-01-08 12:11:42', 'no', 'no', 0, ''),
(115, 'A goal is not always meant to be reached; it often serves simply as something to aim at. -- Bruce Lee', 'katie_rose', 'none', '2018-01-08 12:11:51', 'no', 'no', 1, ''),
(116, 'Success is ... knowing your purpose in life, growing to reach your maximum potential, and sowing seeds that benefit others. --John C. Maxwell', 'katie_rose', 'none', '2018-01-08 12:11:58', 'no', 'no', 1, ''),
(117, 'Be miserable. Or motivate yourself. Whatever has to be done, it\'s always your choice. --Wayne Dyer', 'katie_rose', 'none', '2018-01-08 12:12:13', 'no', 'no', 0, ''),
(118, 'To accomplish great things, we must not only act, but also dream, not only plan, but also believe. --Anatole France', 'katie_rose', 'none', '2018-01-08 12:12:20', 'no', 'no', 1, ''),
(119, 'Most of the important things in the world have been accomplished by people who have kept on trying when there seemed to be no help at all. --Dale Carnegie', 'katie_rose', 'none', '2018-01-08 12:12:30', 'no', 'no', 1, ''),
(120, 'You measure the size of the accomplishment by the obstacles you had to overcome to reach your goals. --Booker T. Washington', 'dave_klinger', 'none', '2018-01-08 12:12:55', 'no', 'no', 0, ''),
(121, 'Real difficulties can be overcome; it is only the imaginary ones that are unconquerable. --Theodore N. Vail', 'dave_klinger', 'none', '2018-01-08 12:13:01', 'no', 'no', 0, ''),
(122, 'It is better to fail in originality than to succeed in imitation. --Herman Melville', 'dave_klinger', 'none', '2018-01-08 12:13:10', 'no', 'no', 0, ''),
(123, 'What would you do if you weren\'t afraid. --Spencer Johnson', 'dave_klinger', 'none', '2018-01-08 12:13:17', 'no', 'no', 0, ''),
(124, 'Little minds are tamed and subdued by misfortune; but great minds rise above it. --Washington Irving', 'dave_klinger', 'none', '2018-01-08 12:13:36', 'no', 'no', 0, ''),
(125, 'Failure is the condiment that gives success its flavor. --Truman Capote', 'dave_klinger', 'none', '2018-01-08 12:13:45', 'no', 'no', 1, ''),
(126, 'Don\'t let what you cannot do interfere with what you can do. --John R. Wooden', 'bob_simpson', 'none', '2018-01-08 12:14:10', 'no', 'no', 1, ''),
(127, 'You may have to fight a battle more than once to win it. --Margaret Thatcher', 'bob_simpson', 'none', '2018-01-08 12:14:19', 'no', 'no', 1, ''),
(128, 'A man can be as great as he wants to be. If you believe in yourself and have the courage, the determination, the dedication, the competitive drive and if you are willing to sacrifice the little things in life and pay the price for the things that are worthwhile, it can be done\" --Vince Lombardi', 'bob_simpson', 'none', '2018-01-08 12:14:26', 'no', 'no', 0, ''),
(131, 'Awesome Posts Katie!!', 'mike_meyer', 'katie_rose', '2018-01-10 00:15:31', 'no', 'no', 1, ''),
(179, 'Nice Mike!!', 'john_dake', 'mike_meyer', '2018-01-11 18:08:11', 'no', 'no', 2, ''),
(188, 'notification check', 'mike_meyer', 'bob_simpson', '2018-01-12 12:37:19', 'no', 'yes', 1, ''),
(194, 'Keep it up!!', 'mike_meyer', 'katie_rose', '2018-01-12 14:41:59', 'no', 'no', 2, ''),
(241, '<br><iframe width=\'420\' height=\'315\' src=\'https://www.youtube.com/embed/HqIkddLfCAk\'></iframe><br>', 'mike_meyer_1', 'none', '2018-01-13 20:14:48', 'no', 'yes', 0, ''),
(242, '<br><iframe width=\'420\' height=\'315\' src=\'https://www.youtube.com/embed/HqIkddLfCAk\'></iframe><br>', 'mike_meyer_1', 'none', '2018-01-13 20:23:45', 'no', 'no', 0, ''),
(243, '<br><iframe width=\'420\' height=\'315\' src=\'https://www.youtube.com/embed/bUTsVY6VUQA\'></iframe><br>', 'mike_meyer_1', 'none', '2018-01-13 20:24:19', 'no', 'no', 0, ''),
(244, 'Hello guys, I am looking forward to this weekend!', 'mike_meyer_1', 'none', '2018-01-14 12:54:17', 'no', 'no', 0, ''),
(247, 'Koala!!', 'mike_meyer_1', 'none', '2018-01-14 13:54:30', 'no', 'no', 1, 'img/posts/5a5b13be1aee1Koala.jpg'),
(248, 'Nice flowers!!', 'mike_meyer_1', 'none', '2018-01-14 14:00:15', 'no', 'no', 0, 'img/posts/5a5b151760b16Tulips.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `posted_by` varchar(100) NOT NULL,
  `posted_to` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `post_body`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`) VALUES
(21, 'Hi\r\n', 'mike_meyer', 'katie_rose', '2018-01-09 14:39:20', 'no', 118),
(22, 'Thats a good one!!', 'mike_meyer', 'katie_rose', '2018-01-09 15:38:12', 'no', 113),
(23, 'True..', 'mike_meyer', 'katie_rose', '2018-01-09 15:55:55', 'no', 119),
(24, 'Keep trying!!', 'mike_meyer', 'katie_rose', '2018-01-09 15:57:16', 'no', 119),
(25, 'Thanks Mike!!', 'katie_rose', 'mike_meyer', '2018-01-10 00:22:02', 'no', 131),
(26, 'It was great!! How was yours??', 'mike_meyer', 'katie_rose', '2018-01-10 17:54:43', 'no', 133),
(27, 'great!!', 'mike_meyer', 'bob_simpson', '2018-01-11 18:03:45', 'no', 128),
(28, 'good one!!', 'mike_meyer', 'dave_klinger', '2018-01-12 14:31:43', 'no', 124),
(29, 'Good One!!', 'mike_meyer', 'bob_simpson', '2018-01-12 14:32:23', 'no', 127),
(30, 'nice..', 'mike_meyer', 'bob_simpson', '2018-01-12 14:33:08', 'no', 126),
(31, 'dsds', 'mike_meyer', 'bob_simpson', '2018-01-12 14:34:34', 'no', 128),
(32, 'dfdfd', 'mike_meyer', 'mike_meyer', '2018-01-12 14:36:59', 'no', 188),
(33, 'nice!!', 'mike_meyer', 'john_dake', '2018-01-12 14:38:18', 'no', 179),
(34, 'ggg', 'mike_meyer', 'mike_meyer', '2018-01-12 14:38:56', 'no', 188),
(35, 'fff', 'mike_meyer', 'mike_meyer', '2018-01-12 14:39:27', 'no', 23),
(36, 'good', 'mike_meyer', 'john_dake', '2018-01-12 16:37:42', 'no', 179),
(37, 'sdadasdas', 'mike_meyer', 'mike_meyer', '2018-01-12 16:38:11', 'no', 240),
(38, 'sadadsa', 'mike_meyer', 'mike_meyer', '2018-01-12 16:38:25', 'no', 194),
(39, 'dsdsd', 'mike_meyer', 'mike_meyer', '2018-01-12 16:38:53', 'no', 23),
(40, 'nice!!', 'katie_rose', 'mike_meyer', '2018-01-12 17:16:14', 'no', 22),
(41, 'Awesome!!', 'katie_rose', 'mike_meyer', '2018-01-12 17:44:40', 'no', 20),
(42, 'Good!!', 'bob_simpson', 'mike_meyer', '2018-01-12 17:47:00', 'no', 20);

-- --------------------------------------------------------

--
-- Table structure for table `trends`
--

CREATE TABLE `trends` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `hits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trends`
--

INSERT INTO `trends` (`id`, `title`, `hits`) VALUES
(1, 'Hello', 1),
(2, 'guys', 1),
(3, 'looking', 1),
(4, 'forward', 1),
(5, 'weekend', 1),
(7, 'Koala', 2),
(8, 'Nice', 1),
(9, 'flowers', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` varchar(200) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `friend_array` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `signup_date`, `profile_pic`, `num_posts`, `num_likes`, `user_closed`, `friend_array`) VALUES
(9, 'Mike', 'Meyer', 'mike_meyer', 'Mike@gmail.com', '4c3e1ec04215f69d6a8e9c023c9e4572', 'Jan-05-2018 19:42:58', 'img/profile_pics/default/head_wisteria.png', 93, 16, 'no', ',katie_rose,bob_simpson,john_dake,dave_klinger,mary_jane,'),
(17, 'Max', 'Smith', 'max_smith', 'Max@gmail.com', 'd1696816bc1a7afe92f1c8787ac222c3', 'Jan-05-2018 20:13:12', 'img/profile_pics/default/head_pumpkin.png', 19, 1, 'no', ','),
(18, 'Mary', 'Jane', 'mary_jane', 'Mary@gmail.com', 'f387c152606d845d3c4fcb4137b0c084', 'Jan-05-2018 20:30:19', 'img/profile_pics/default/head_wisteria.png', 24, 1, 'no', ',katie_rose,mike_meyer,'),
(19, 'John', 'Dake', 'john_dake', 'John@gmail.com', '6e0b7076126a29d5dfcbd54835387b7b', 'Jan-08-2018 11:51:55', 'img/profile_pics/default/head_belize_hole.png', 20, 2, 'no', ',bob_simpson,mike_meyer,mike_meyer,'),
(20, 'Dave', 'Klinger', 'dave_klinger', 'Dave@gmail.com', '70b9f55c5b2ab6ab9e5a3fed086f1ce7', 'Jan-08-2018 11:52:55', 'img/profile_pics/default/head_wet_asphalt.png', 18, 1, 'no', ',mike_meyer,'),
(21, 'Bob', 'Simpson', 'bob_simpson', 'Bob@gmail.com', '2acba7f51acfd4fd5102ad090fc612ee', 'Jan-08-2018 11:53:13', 'img/profile_pics/default/head_sun_flower.png', 18, 2, 'no', ',john_dake,'),
(22, 'Katie', 'Rose', 'katie_rose', 'Katie@gmail.com', 'dc04cdc4875e544eab18c85b4204aa47', 'Jan-08-2018 11:54:06', 'img/profile_pics/default/head_amethyst.png', 18, 11, 'no', ',mike_meyer,mary_jane,'),
(23, 'Mike', 'Meyer', 'mike_meyer_1', 'Mike1@gmail.com', '4c3e1ec04215f69d6a8e9c023c9e4572', 'Jan-10-2018 15:25:23', 'img/profile_pics/default/head_amethyst.png', 13, 2, 'no', ',');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trends`
--
ALTER TABLE `trends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `trends`
--
ALTER TABLE `trends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
