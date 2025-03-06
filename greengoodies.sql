-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Data base : `greengoodies`
--
-- --------------------------------------------------------
--
-- Hydrates table `product`
--

INSERT INTO `product` (`id`, `name`, `description_short`, `description_long`, `image`, `quantity`, `price`) VALUES
(1, 'Kit d hygiène recyclable', 'Pour une salle de bain éco-frendly', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_1_Lite', '0', '24,99'),
(2, 'Shot Tropical', 'Fruit frais, pressés à froid', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_2_Lite', '0', '5,50'),
(3, 'Gourde en bois', '50cl, bois d olivier', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_3_Lite', '0', '16,90'),
(4, 'Disque Démaquillants x3', 'Solution efficace pour vous démaquiller en douceur', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_4_Lite', '0', '19,90'),
(5, 'Bougie Lavande & Patchouli', 'Cire naturelle', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_5_Lite', '0', '32'),
(6, 'Brosse à dent', 'Bois de hêtre rouge issu de forêts gérées durablement', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_6_Lite', '0', '5,40'),
(7, 'Kit de couverts en bois', 'Revêtement Bio en olivier & sac de transport', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_7_Lite', '0', '12,30'),
(8, 'Nécessaire, déodorant Bio', '50ml déodorant à l eucalyptus', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_8_Lite', '0', '8,50'),
(9, 'Savon Bio', 'Thé, Orange & Girofle', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_9_Lite', '0', '18,90');

-- --------------------------------------------------------
--
-- Hydrates table `order_production`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name` ) VALUES
(1, 'user1@greengoodies', '[ROLE_USER]', 'password', 'Prenom1', 'Nom1'),
(2, 'user2@greengoodies', '[ROLE_USER]', 'password', 'Prenom2', 'Nom2'),
(3, 'user3@greengoodies', '[ROLE_USER]', 'password', 'Prenom3', 'Nom3'),
(4, 'user4@greengoodies', '[ROLE_USER]', 'password', 'Prenom4', 'Nom4'),
(5, 'user5@greengoodies', '[ROLE_USER]', 'password', 'Prenom5', 'Nom5'),
(6, 'user6@greengoodies', '[ROLE_USER]', 'password', 'Prenom6', 'Nom6');

-- --------------------------------------------------------
--
-- Hydrates table `order_production`
--

INSERT INTO `order` (`id`, `client_id`, `date`, `validated` ) VALUES
(1, 2, '2024-10-17 10:51:26', '1'),
(2, 5, '2024-11-13 12:47:23', '1'),
(3, 6, '2024-11-17 08:15:38', '1'),
(4, 2, '2025-01-17 10:52:46', '1'),
(5, 5, '2025-02-17 17:11:58', '1'),
(6, 5, '2025-02-17 17:51:26', '1');

-- --------------------------------------------------------
--
-- Hydrates table `order_production`
--

INSERT INTO `order_product` (`order_id`, `product_id`) VALUES
(1, 2),
(2, 5),
(3, 6),
(4, 2),
(5, 8),
(6, 9),
(4, 3),
(4, 4),
(5, 5),
(6, 7);

-- --------------------------------------------------------




/*--
-- Structure of the table `messaging`
--

DROP TABLE IF EXISTS `messaging`;
CREATE TABLE IF NOT EXISTS `messaging` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `receiver_read` boolean NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
*/


