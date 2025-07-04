# ArtGallery Platform – Backend API Checklist

This README documents all the backend modules and endpoints for your PHP-based art marketplace. Use it to verify, test, and integrate your system.

---

## Folder Structure

/api/
├── artworks/
├── custom_requests/
├── transactions/
├── users/
├── db.php
├── session.php
├── download.php
├── summary.php
/uploads/

---

## Users Module

| Endpoint                  | Method | Description                        |
| ------------------------- | ------ | ---------------------------------- |
| `/users/create.php`       | POST   | Register new user (default: Buyer) |
| `/users/login.php`        | POST   | Login and create session           |
| `/users/logout.php`       | GET    | Logout and destroy session         |
| `/users/read.php`         | GET    | Get current logged-in user's info  |
| `/users/update.php`       | POST   | Update user profile info           |
| `/users/upload_photo.php` | POST   | Upload profile photo               |
| `/users/upgrade.php`      | POST   | Upgrade Buyer to Artist            |
| `/users/list.php`         | GET    | Admin: List all users              |
| `/users/profile.php?id=`  | GET    | Public artist profile view         |

---

## Artworks Module

| Endpoint                 | Method | Description                           |
| ------------------------ | ------ | ------------------------------------- |
| `/artworks/create.php`   | POST   | Create artwork (digital or physical)  |
| `/artworks/read.php?id=` | GET    | View a single artwork                 |
| `/artworks/list.php`     | GET    | List artworks (with optional filters) |
| `/artworks/update.php`   | POST   | Update artwork (requires login)       |
| `/artworks/delete.php`   | POST   | Delete artwork                        |

Supports: type (digital/physical), price, image, quantity (for physical only)

---

## Custom Requests Module

| Endpoint                        | Method | Description                            |
| ------------------------------- | ------ | -------------------------------------- |
| `/custom_requests/create.php`   | POST   | Create a custom art request (any user) |
| `/custom_requests/list.php`     | GET    | Artists view available requests        |
| `/custom_requests/read.php?id=` | GET    | Artist views a single request          |
| `/custom_requests/update.php`   | POST   | Artist updates progress/status         |

---

## Transactions Module

| Endpoint                     | Method | Description                              |
| ---------------------------- | ------ | ---------------------------------------- |
| `/transactions/create.php`   | POST   | Buyer initiates purchase                 |
| `/transactions/read.php?id=` | GET    | View a single transaction                |
| `/transactions/list.php`     | GET    | List user's purchases/sales (role-based) |
| `/transactions/update.php`   | POST   | Artist updates payment/delivery status   |

Logic:

- Digital: allows download
- Physical: deducts quantity, blocks sold-out from buyers

---

## Other Endpoints

| File           | Purpose                                |
| -------------- | -------------------------------------- |
| `db.php`       | Sets up database connection            |
| `session.php`  | Verifies login session for access      |
| `download.php` | Allows buyer to download digital files |
| `summary.php`  | Returns dashboard stats (role-based)   |

---

## Uploads Structure

- `/uploads/` – artwork images
- `/uploads/profiles/` – artist profile photos

---

## Testing Tips

- Test all endpoints with **Postman** or **Insomnia**
- Always log in before calling protected endpoints
- Use `$_SESSION['user_id']` to secure access
- Set `enctype="multipart/form-data"` when uploading files
