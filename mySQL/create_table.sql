

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `articles`
--

-- --------------------------------------------------------

--
-- Table structure for table `diffbot_articles`
--

CREATE TABLE IF NOT EXISTS `diffbot_articles` (
  `Content_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Content_Type_ID` int(10) NOT NULL,
  `Processing_Status` int(10) NOT NULL,
  `Content_URL` varchar(255) NOT NULL,
  `Website_Domain_Name` varchar(255) NOT NULL,
  `Content_Title` varchar(255) NOT NULL,
  `Content_Image_Path` varchar(255) NOT NULL,
  `Content_Text` text NOT NULL,
  `Content_Text_HTML` text NOT NULL,
  `Content_Author_Name` varchar(255) NOT NULL,
  `Content_Date` varchar(255) NOT NULL,
  `Content_Tags` varchar(255) NOT NULL,
  `To_Process` int(10) NOT NULL,
  PRIMARY KEY (`Content_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
