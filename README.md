# LinkUp

LinkUp is a social media platform where users can connect with others, share content, and participate in discussions. This project includes functionalities such as user registration, login, post creation, comments, likes, tags, user roles, and follower relationships.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [Authors and Acknowledgments](#authors-and-acknowledgments)

## Installation

### Prerequisites

- PHP version 7.4 or higher
- MySQL
- Apache or Nginx

### Steps

1. Clone the repository
3. Set up a local server:
   Use XAMPP or any other local server setup that supports PHP and MySQL. Start the Apache and MySQL services.

4. Create a database:
   Create a database named `linkup` in your MySQL server.

5. Import the database schema:
   Import the `linkup.sql` file located in the root directory of the project to set up the database schema.

6. Configure the database connection:
   Update the `includes/db.php` file with your database credentials:
    ```php
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "linkup";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
    ```

7. Run the application:
   Place the project files in your web server's root directory (e.g., `C:\xampp\htdocs\linkup`), and open your browser to `http://localhost/linkup`.

## Usage

- **Sign Up:** Create a new account by providing a username, email, and password.
- **Login:** Log in with your registered email and password.
- **Profile:** View and edit your profile information, including bio and profile picture.
- **Posts:** Create, view, edit, and delete posts. Posts can include text and images.
- **Comments:** Add comments to posts.
- **Likes:** Like and unlike posts.
- **Tags:** Tag your posts with relevant tags.
- **Follow:** Follow and unfollow other users.


## Authors and Acknowledgments

- **Deacon Mizzi** - *LinkUp* - [Github Profile](https://github.com/DeaconMizzi)


