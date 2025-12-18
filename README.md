# BlogCMS - Simple Procedural PHP Blog System

A complete, secure blog management system built with native procedural PHP, MySQL, and Bootstrap 5.

## 📋 Features

### For All Users

- Secure login/registration system
- Role-based access control (Admin, Author, Visitor)
- Browse published articles
- Search functionality
- Comment on articles
- Category filtering

### For Authors

- View all published articles
- Create new articles
- Edit own articles
- Delete own articles
- Post comments

### For Administrators

- Dashboard with statistics
- Full CRUD for articles
- Full CRUD for categories
- Moderate comments (approve/reject/delete)
- Manage users (create/edit/delete)
- View all system statistics

## 🛠️ Technologies Used

### Backend

- PHP 8+ (Procedural)
- MySQL Database
- PDO with Prepared Statements

### Frontend

- HTML5 / CSS3
- Bootstrap 5.3
- Bootstrap Icons
- JavaScript

### Security Features

- ✅ Password hashing with bcrypt
- ✅ XSS protection (htmlspecialchars)
- ✅ SQL injection protection (prepared statements)
- ✅ CSRF protection via sessions
- ✅ Input validation and sanitization
- ✅ Secure session management

## 📁 Project Structure

```
blogcms/
├── config.php              # Database configuration
├── functions.php           # Helper functions
├── login.php              # Login & registration
├── logout.php             # Logout handler
├── index.php              # Home page (articles list)
├── article.php            # Single article view
├── category.php           # Category articles view
├── my_articles.php        # Author's article management
├── edit_article.php       # Edit article page
└── admin/
    ├── dashboard.php      # Admin dashboard
    ├── articles.php       # Manage all articles
    ├── categories.php     # Manage categories
    ├── comments.php       # Moderate comments
    └── users.php          # Manage users
```

## 🚀 Installation

### Prerequisites

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- phpMyAdmin (optional)

### Steps

1. **Clone or download the project**

   ```bash
   git clone <your-repo-url>
   cd blogcms
   ```

2. **Import the database**

   - Open phpMyAdmin
   - Create a new database named `blog_cms`
   - Import the provided SQL file: `blog_cms.sql`

3. **Configure database connection**

   - Open `config.php`
   - Update the database credentials:

   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'blog_cms');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   ```

4. **Set up web server**

   - Place files in your web server directory (htdocs, www, etc.)
   - Ensure Apache/Nginx is running
   - Access via: `http://localhost/blogcms/`

5. **Login with demo credentials**
   - Admin: `admin_blog` / `admin1234`
   - User: `jean_dupont` / `user1234`

## 🔐 Default Accounts

| Username         | Password  | Role   |
| ---------------- | --------- | ------ |
| admin_blog       | admin1234 | Admin  |
| caroline_duval   | admin1234 | Admin  |
| vincent_gauthier | admin1234 | Admin  |
| jean_dupont      | user1234  | Author |
| sophie_martin    | user1234  | Author |

## 💾 Database Schema

### Tables

- **users** - User accounts and authentication
- **article** - Blog articles/posts
- **categorie** - Article categories
- **commentaire** - Comments on articles

### Key Relationships

- Articles belong to Categories
- Articles belong to Users (authors)
- Comments belong to Articles
- Comments belong to Users

## 🎯 Usage Guide

### Creating Articles

1. Login as an author or admin
2. Navigate to "My Articles"
3. Click "Create New Article"
4. Fill in title, category, and content
5. Click "Create Article"

### Managing Categories (Admin)

1. Login as admin
2. Go to Admin Dashboard → Categories
3. Add/edit/delete categories as needed

### Moderating Comments (Admin)

1. Login as admin
2. Go to Admin Dashboard → Comments
3. Approve, reject, or delete comments

### Managing Users (Admin)

1. Login as admin
2. Go to Admin Dashboard → Users
3. Create, edit, or delete user accounts
4. Assign admin privileges as needed

## 🔒 Security Best Practices

1. **Password Security**

   - All passwords are hashed using bcrypt
   - Minimum 6 characters required
   - Change default passwords immediately

2. **Input Validation**

   - All user inputs are validated server-side
   - XSS protection via htmlspecialchars()
   - SQL injection prevention via prepared statements

3. **Session Security**

   - Sessions are properly initialized
   - Session data is validated on each request
   - Automatic logout on browser close

4. **Access Control**
   - Role-based permissions enforced
   - Admin-only pages check isAdmin()
   - Users can only edit their own content

## 📝 Code Structure

### config.php

- Database connection with PDO
- Session initialization
- Global configuration

### functions.php

All helper functions including:

- Security functions (escape, isLoggedIn, isAdmin)
- CRUD operations for articles, categories, comments, users
- Data retrieval functions
- Search and statistics functions

### Page Files

Each page includes:

- Authentication checks
- CRUD operations handling
- Data retrieval
- HTML template with Bootstrap

## 🎨 Customization

### Changing Design

- Bootstrap 5 is used throughout
- Modify HTML templates in each .php file
- Add custom CSS in the `<head>` section

### Adding Features

1. Add function to `functions.php`
2. Create or modify page file
3. Update navigation as needed
4. Test thoroughly

## 🐛 Troubleshooting

### Common Issues

**Database Connection Error**

- Check `config.php` credentials
- Verify MySQL is running
- Confirm database exists

**Login Not Working**

- Clear browser cookies/cache
- Check session configuration
- Verify user exists in database

**Page Not Found (404)**

- Check file permissions
- Verify .htaccess configuration
- Ensure mod_rewrite is enabled

**Comments Not Showing**

- Check comment status (approved/pending)
- Verify user is logged in
- Check article ID is valid

## 📊 Testing Checklist

- [ ] User registration works
- [ ] User login/logout works
- [ ] Articles can be created
- [ ] Articles can be edited
- [ ] Articles can be deleted
- [ ] Comments can be posted
- [ ] Categories can be managed
- [ ] Users can be managed
- [ ] Search functionality works
- [ ] Admin dashboard shows correct stats
- [ ] XSS protection works
- [ ] SQL injection protection works

## 🚀 Deployment

### Production Checklist

1. Change all default passwords
2. Update database credentials
3. Enable HTTPS
4. Set appropriate file permissions
5. Disable error display
6. Enable logging
7. Backup database regularly

## 📄 License

This project is created for educational purposes as part of the BlogCMS brief.

## 👥 Contributors

- Your Name - Initial development

## 📞 Support

For issues or questions:

1. Check this README
2. Review the code comments
3. Test with demo credentials
4. Create an issue in the repository

---

**Note**: This is a simple procedural PHP implementation. For production use, consider implementing additional features like:

- Image upload functionality
- Pagination for large datasets
- Email notifications
- Password reset functionality
- Rate limiting
- More robust error handling
- Logging system
- API endpoints
