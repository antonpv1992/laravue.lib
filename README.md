# Laravel and Vue library project.

The library is written using a laravel backend and a vue frontend.  
Implemented authorization/registration with passport tokens.  
Implemented user verification with sending a letter to the mail.  
There is a password reset functionality using sending a letter to the mail.  
Also implemented authorization/registration via Google and Facebook.  
It is possible to view the book/list of books, add/delete/edit.  
The same functionality is available for users.  
Role system in place:  
1.The guest has access to the home page, registration/authorization and password reset.
2.The user can view all pages except the list of users, and also cannot edit / delete books and users.  
3.All actions are available to the administrator.  
The user/admin has the opportunity to search for the desired book, as well as sort it.  
The project also used the swagger documentation library and three types of codeception library tests  
