-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2023 at 12:57 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `megamindlibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `user_id`, `created_at`, `category`) VALUES
(68, 'The Future of AI 1', 'Artificial intelligence (AI) is rapidly changing the world we live in. From self-driving cars to personalized recommendations, AI is revolutionizing industries and changing the way we interact with technology.', 6, '2023-02-22 12:55:17', 'tech'),
(69, 'Top 10 Programming Languages of 2023', 'As technology continues to advance, programming languages are also evolving. Here are the top 10 programming languages you should learn in 2023. JavaScript languages like React.js, Angular.js and others, Python and Java.', 7, '2023-02-22 12:55:17', 'tech'),
(71, '5 Outdoor Activities for a Fun-Filled Weekend', 'Get out and enjoy the great outdoors with these fun and exciting activities. From hiking to kayaking, there is something for everyone to enjoy.', 7, '2023-02-22 12:55:17', 'recreation'),
(75, '10 Tips for Building a Successful Business', 'Building a successful business takes hard work and dedication. From creating a solid business plan to building a strong team, these tips will help you achieve your goals.', 7, '2023-02-22 12:55:17', 'business'),
(76, 'The Art of Cooking', 'Cooking is both an art and a science. From mastering basic techniques to experimenting with new flavors, cooking is a fun and rewarding experience. Discover the joy of cooking and unleash your inner chef.', 6, '2023-02-22 12:55:17', 'food'),
(77, 'The Beauty of Nature', 'Nature is a source of inspiration and wonder. From towering mountains to crystal clear lakes, the beauty of nature can be found all around us. Take a journey into the great outdoors and explore the wonders of the natural world.', 7, '2023-02-22 12:55:17', 'travel'),
(79, '10 Simple Tips for a Healthy Lifestyle', 'Living a healthy lifestyle is important for both physical and mental well-being. From eating a balanced diet to getting enough exercise, these simple tips will help you improve your overall health.', 6, '2023-02-22 12:55:17', 'health'),
(80, 'The World of Virtual Reality', 'Virtual reality is an exciting new technology that allows users to immerse themselves in a virtual world. From gaming to education, the possibilities of virtual reality are endless.', 7, '2023-02-22 12:55:17', 'tech'),
(81, 'The Art of Photography', 'Photography is both a form of art and a way to capture memories. From mastering the basics of composition to experimenting with different techniques, photography is a fun and rewarding hobby. Discover the art of photography and unleash your creative side.', 7, '2023-02-22 12:55:17', 'art'),
(83, 'The History of the Internet', 'The internet has revolutionized the way we communicate and access information. From its humble beginnings to its current state, learn about the history of the internet and its impact on society.', 6, '2023-02-22 12:55:17', 'tech'),
(88, 'The Benefits of Travel', 'Traveling is not only fun and exciting, but it also has many benefits for your overall well-being. From experiencing new cultures to expanding your horizons, learn about the many benefits of travel and start planning your next adventure.', 6, '2023-02-22 12:55:17', 'travel'),
(89, 'How to Code a Basic Website', 'Coding a website can seem like a daunting task, but it doesn’t have to be. Follow these simple steps to create a basic website from scratch and start building your online presence today.', 6, '2023-02-22 12:55:17', 'programming'),
(91, '10 Tips for a Successful Job Interview', 'Preparing for a job interview can be stressful, but it doesn’t have to be. Follow these 10 tips to help you ace your next job interview and land the job of your dreams.', 7, '2023-02-22 12:55:17', 'business'),
(92, 'The Benefits of Yoga', 'Yoga is a great way to improve your physical and mental health. From reducing stress to improving flexibility, learn about the many benefits of yoga and how to get started on your own yoga journey.', 6, '2023-02-22 12:55:17', 'health'),
(94, 'How to Write a Bestselling Novel', 'Writing a novel can be a daunting task, but it doesn’t have to be. Follow these simple tips to help you write a novel that will captivate readers and become a bestseller.', 7, '2023-02-22 12:55:17', 'romance'),
(96, 'The World of Cryptocurrency1', 'Cryptocurrency is a digital currency that has gained popularity in recent years. Learn about the world of cryptocurrency and how it works, including the benefits and risks of investing in this new and exciting technology.', 6, '2023-02-22 12:55:17', 'finance'),
(98, 'The Bird Joke', 'Once upon a time, there was a man who had a pet bird. This bird was very special because it could sing any song that the man sang to it. The man loved to sing, so he was thrilled to have a bird that could sing along with him.\\r\\n\\r\\nOne day, the man was singing a beautiful song, and the bird was singing along with him. Suddenly, the man forgot the words to the song, and he stopped singing. The bird kept singing, but it was singing the wrong words.\\r\\n\\r\\nThe man was amazed that the bird knew the song better than he did, and he decided to take the bird to a talent show. At the talent show, the man introduced the bird and asked it to sing the same song that he had sung before.\\r\\n\\r\\nThe bird started singing, and everyone in the audience was amazed. The bird sang beautifully, and it even knew all the right words. The audience cheered and clapped, and the man was very proud of his bird.\\r\\n\\r\\nAfter the talent show, the man and the bird went back home. The man was so happy that he decided to sing another song. He started singing, and the bird started singing along with him.\\r\\n\\r\\nBut then, the man suddenly stopped singing again. The bird kept singing, but this time, it wasn\\\'t singing the right words. It was singing a completely different song!\\r\\n\\r\\nThe man was confused and asked the bird why it was singing a different song. The bird looked at the man and said, \\\"I\\\'m sorry, I thought we were doing requests now!\\\"', 7, '2023-03-09 21:22:27', 'Recreation');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(15) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(2, 'Programming'),
(3, 'Accounting'),
(4, 'History'),
(5, 'Music'),
(6, 'Recreation'),
(9, 'Travel'),
(10, 'News'),
(11, 'Home'),
(12, 'Technology'),
(13, 'Science'),
(14, 'Romance'),
(15, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `doc_types`
--

CREATE TABLE `doc_types` (
  `id` int(15) NOT NULL,
  `type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doc_types`
--

INSERT INTO `doc_types` (`id`, `type_name`) VALUES
(1, 'Book'),
(2, 'Article'),
(3, 'Newspaper'),
(4, 'Magazine');

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` int(15) NOT NULL,
  `field_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `field_name`) VALUES
(2, 'Programming'),
(3, 'Accounting'),
(4, 'History'),
(7, 'Music'),
(8, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT 0,
  `file_path` varchar(255) NOT NULL DEFAULT '',
  `description` text DEFAULT NULL,
  `public` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(255) NOT NULL,
  `posted_by` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `doc_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `title`, `author`, `filename`, `file_size`, `file_path`, `description`, `public`, `user_id`, `created_at`, `category`, `posted_by`, `image_path`, `image`, `doc_type`) VALUES
(17, 'How To Read Music', 'Ben Dunnet', 'Jane Doe_20230228_135438.pdf', 6315614, '../uploads/Jane Doe_20230228_135438.pdf', '7 Easy Lessons', 0, 9, '2023-02-28 12:54:38', 'music', 'Jane Doe', '../uploads/images/Jane Doe_20230228_135438.jpg', 'Jane Doe_20230228_135438.jpg', ''),
(18, 'React Js', 'Gibs', 'John Doe_20230309_142105.pdf', 29461530, '../uploads/John Doe_20230309_142105.pdf', 'A programmer\'s cook book', 0, 7, '2023-03-09 13:21:05', 'programming', 'John Doe', '../uploads/images/John Doe_20230309_142105.jpg', 'John Doe_20230309_142105.jpg', ''),
(19, 'Data Mining', 'Adero', 'John Doe_20230311_085701.pdf', 11552324, '../uploads/John Doe_20230311_085701.pdf', 'A programmer\'s cook book', 0, 7, '2023-03-11 07:57:01', 'Programming', 'John Doe', '../uploads/images/John Doe_20230311_085701.jpg', 'John Doe_20230311_085701.jpg', 'Book'),
(31, 'Online Shopping', 'Windows User', 'Adero_20230314_193308.pdf', 2720356, '../uploads/Adero_20230314_193308.pdf', 'Online Shopping Woes', 0, 13, '2023-03-14 18:33:08', 'Others', 'Adero', '../uploads/images/Adero_20230314_193308.jpeg', 'Adero_20230314_193308.jpeg', 'Book'),
(32, 'The C Programming Language', 'Easy Programming Publisher', 'Adero_20230321_112257.pdf', 11071632, '../uploads/Adero_20230321_112257.pdf', 'The Ultimate Beginner’s Guide', 0, 13, '2023-03-21 10:22:57', 'Programming', 'Adero', '../uploads/images/Adero_20230321_112257.jpeg', 'Adero_20230321_112257.jpeg', 'Book'),
(33, 'Programming Android', 'Zigurd Mednieks, Laird Dornin, G. Blake Meike, and Masumi Nakamura', 'Adero_20230321_112715.pdf', 8619703, '../uploads/Adero_20230321_112715.pdf', 'Java Programming for The New Generation of Android Devices', 0, 13, '2023-03-21 10:27:15', 'Programming', 'Adero', '../uploads/images/Adero_20230321_112715.jpg', 'Adero_20230321_112715.jpg', 'Book'),
(34, 'Accounting For Non-Accountants', 'Wayn A. Label, CPA, MBA, PHD', 'Adero_20230321_113150.pdf', 1235305, '../uploads/Adero_20230321_113150.pdf', 'Accounting For Non-Accountants: Faster and easy way to learn the basics. 3rd Edition', 0, 13, '2023-03-21 10:31:50', 'Accounting', 'Adero', '../uploads/images/Adero_20230321_113150.jpg', 'Adero_20230321_113150.jpg', 'Book'),
(35, 'Finance And Accounting', 'Cheng-Few Lee', 'Adero_20230321_113513.pdf', 2058453, '../uploads/Adero_20230321_113513.pdf', 'Advances in Quantitative Analysis of Finance and Accounting', 0, 13, '2023-03-21 10:35:13', 'Accounting', 'Adero', '../uploads/images/Adero_20230321_113513.jpg', 'Adero_20230321_113513.jpg', 'Book'),
(36, 'Accounting Made Simple', 'Mike Piper', 'Adero_20230321_113752.pdf', 587815, '../uploads/Adero_20230321_113752.pdf', 'Accounting Made Simple: Accounting Explained in 100 Pages or Less', 0, 13, '2023-03-21 10:37:52', 'Accounting', 'Adero', '../uploads/images/Adero_20230321_113752.jpg', 'Adero_20230321_113752.jpg', 'Book'),
(37, 'Franlin Newspaper July 1, 2014', 'Franklin News', 'Adero_20230321_120800.pdf', 7849069, '../uploads/Adero_20230321_120800.pdf', 'The Franlin Newspaper', 0, 13, '2023-03-21 11:08:00', 'Others', 'Adero', '../uploads/images/Adero_20230321_120800.jpg', 'Adero_20230321_120800.jpg', 'Newspaper'),
(38, 'Yoga For Men', 'Yoga group', 'Adero_20230321_121241.pdf', 1006399, '../uploads/Adero_20230321_121241.pdf', '2nd Edition: Yoga For Men Beginner’s Step by Step Guide to a Stronger Body & Sharper Mind', 0, 13, '2023-03-21 11:12:41', 'Recreation', 'Adero', '../uploads/images/Adero_20230321_121241.jpg', 'Adero_20230321_121241.jpg', 'Magazine'),
(39, 'Napoleon Hell', 'Ken Blanchard', 'Adero_20230321_121559.pdf', 1906664, '../uploads/Adero_20230321_121559.pdf', 'Napoleon Hell: How To Sell Your Way Through Life', 0, 13, '2023-03-21 11:15:59', 'History', 'Adero', '../uploads/images/Adero_20230321_121559.jpg', 'Adero_20230321_121559.jpg', 'Book'),
(40, 'Exotic Fashion Magazine', 'XOTIC Adventure & Travel Enterprises, Inc.', 'Adero_20230402_121229.pdf', 13124348, '../uploads/Adero_20230402_121229.pdf', 'E Fashion, Sports, Activewear, Olympics: Exotic fashion 10 years anniversary', 0, 13, '2023-04-02 10:12:29', 'Romance', 'Adero', '../uploads/images/Adero_20230402_121229.png', 'Adero_20230402_121229.png', 'Magazine'),
(41, 'GQ Magazine', 'Varun Dawan', 'Adero_20230402_121804.pdf', 30699835, '../uploads/Adero_20230402_121804.pdf', 'September Style Special: How to throw the Ultimate bash and others', 0, 13, '2023-04-02 10:18:04', 'Others', 'Adero', '../uploads/images/Adero_20230402_121804.png', 'Adero_20230402_121804.png', 'Magazine'),
(42, 'Gress Magazine', 'The Gress G', 'Adero_20230402_122505.pdf', 16336432, '../uploads/Adero_20230402_122505.pdf', 'BEST MEN MAGAZINE 2015', 0, 13, '2023-04-02 10:25:05', 'Romance', 'Adero', '../uploads/images/Adero_20230402_122505.png', 'Adero_20230402_122505.png', 'Magazine'),
(43, 'Guitar Techniques', 'G Techs', 'Adero_20230402_122810.pdf', 17988987, '../uploads/Adero_20230402_122810.pdf', 'PLAY BLuES • ROck • jazz • acOuSTic • LEad • RhyThM •and MORE!', 0, 13, '2023-04-02 10:28:10', 'Music', 'Adero', '../uploads/images/Adero_20230402_122810.png', 'Adero_20230402_122810.png', 'Magazine'),
(44, 'Magazine Media Factbook', 'Association of Magazine Media', 'Adero_20230402_123139.pdf', 1032456, '../uploads/Adero_20230402_123139.pdf', 'Here at your fingertips are more than 100 pages of audited, accredited and validated facts about the power of magazine media for you  to reference and incorporate into your daily conversations. The annual MPA Factbook is one of the most widely sourced and relied upon  tools in our industry. We receive and fulfill thousands of requests for the book, and its prevalence increased last year when every page  became available online as a downloadable PowerPoint slide.', 0, 13, '2023-04-02 10:31:39', 'News', 'Adero', '../uploads/images/Adero_20230402_123139.png', 'Adero_20230402_123139.png', 'Magazine'),
(45, 'Learning Node Js', 'Krishna Rungta', 'Adero_20230402_125059.pdf', 6337031, '../uploads/Adero_20230402_125059.pdf', 'Learn NodeJS in 1 Day By Krishna Rungta', 0, 13, '2023-04-02 10:50:59', 'Programming', 'Adero', '../uploads/images/Adero_20230402_125059.png', 'Adero_20230402_125059.png', 'Book');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_title` varchar(255) NOT NULL,
  `decline_reason` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `item_title` varchar(255) DEFAULT NULL,
  `item_id` int(15) DEFAULT NULL,
  `admin_response` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `request` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `request_title`, `decline_reason`, `created_at`, `status`, `item_title`, `item_id`, `admin_response`, `email`, `username`, `request`) VALUES
(1, 7, 'Book request', '', '2023-03-14 17:00:53', 'replied', 'Online Shopping', 31, NULL, 'johndoe@gmail.com', 'John Doe', 'Requesting a book of Cryptocurrency by Bennet');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` varchar(15) NOT NULL DEFAULT 'regular',
  `field` varchar(255) NOT NULL,
  `reset_code` varchar(255) NOT NULL,
  `reset_timestamp` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `user_level`, `field`, `reset_code`, `reset_timestamp`) VALUES
(6, 'megadeon13@gmail.com', 'Megan', '$2y$10$SPzAUTrxHBUWUBLmBSNx1.Qr3hhYaYUp0D2N98ECN7NHQ0acHPM.O', 'regular', 'Music', '', '2023-03-30 15:10:14.146214'),
(7, 'johndoe@gmail.com', 'John Doe', '$2y$10$q0qTu6rDDvyPU0ngIKASeuJToyRfoNeI6CYLgpliaa2Nqr2cB.4Uq', 'regular', 'Programming', '', '2023-03-30 17:11:44.913541'),
(9, 'janedoe@gmail.com', 'Jane Doe2', '$2y$10$TYeZKWfT4m0SH6DB8QN51uzmPLjn44z59RE2v//gqWW9XbMj/dgK.', 'regular', 'Programming', '', '2023-03-30 15:10:14.146214'),
(11, 'user1@gmail.com', 'UserOne', '$2y$10$yywB1EoZpJsTd/BDouPhIes5guJgmEbp6HcEp4nqIxlh9aUpoVNsq', 'regular', 'Accounting', '', '2023-03-30 15:10:14.146214'),
(13, 'aderomourice7@gmail.com', 'Adero', '$2y$10$o/WK/c/HJ1xmEUIBCm5KH.vUOfINSCagmsL3SHNqjcFi8pU6qyKJ2', 'admin', 'Administrator', '', '2023-04-02 10:07:18.616759'),
(14, 'fatjoe@gmail.com', 'FatJoe', '$2y$10$AlzOuDhWUbSyhyZZzjQDruGSf54jS8o44HzGZndFaZTy5iarlnlm6', 'regular', 'Music', '', '2023-03-30 15:10:14.146214'),
(16, 'edward.kirui@gmail.com', 'Kirui', '$2y$10$9dF3jrXOB70oTmODrXAmf.QaXkXfEyeo6hAAD4XG7wHma2pUeH3aK', 'regular', '', '', '2023-03-30 15:10:14.146214'),
(17, 'faith@gmail.com', 'Faith', '$2y$10$hHyBb/lvHbsJaIFEgDvMq.sxAWTQb/x2GgOUSmNFzV1EK6QWDLAXG', 'regular', 'Music', '', '2023-03-30 15:10:14.146214'),
(25, 'jacky123@gmail.com', 'Jacky', '$2y$10$nUpJOOvOa/C9BqYsZBM/4.5bA66XwxhpnCq.EucH.FtRgtlaidz4S', 'regular', 'Other', '', '2023-04-02 10:38:56.963099');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articles_ibfk_1` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doc_types`
--
ALTER TABLE `doc_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_ibfk_1` (`user_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `doc_types`
--
ALTER TABLE `doc_types`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
