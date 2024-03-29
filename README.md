# Guest Post/Page Submission Plugin
[![Build Status](https://api.travis-ci.org/wp-strap/wordpress-plugin-boilerplate.svg?branch=master&status=passed)](https://travis-ci.org/github/wp-strap/wordpress-plugin-boilerplate)
![PHP 7.1+](https://img.shields.io/badge/PHP-7.1%2B-brightgreen)
<table  width='100%'  align="center">
<tr>
<td  align='left'  width='100%'  colspan='2'>
<strong>Plugin boilerplate with modern tools to kickstart your WordPress project</strong><br  />
This includes common and modern tools to facilitate plugin development and testing with an organized, object-oriented structure and kick-start a build-workflow for your WordPress plugins.
</td>
</tr>
</table>

## Guest Post/Page Submission Plugin
This exercise is about creating an interface in Front-end site of website, so that guest authors can submit posts from front-side. Using this interface, the guest author should be able to create a post from front side. You will also need to create another page where all the posts created by this author will be listed.

To achieve this, you should create a new user from wpadmin dashboard with Author role, which you can use in this exercise.

Also, you should create a custom post type as “guest posts” and develop a Post creation form UI on frontend through a shortcode or a Gutenberg block. The form should be visible only to logged in authors.

### The form must have the following mandatory fields:
* Post Title:
* Dropdown (Fetch existing custom post type)
* Description
* Excerpt
* Featured image

The form must be sent via AJAX and saved as draft mode in the WordPress database. Once the form is sent, admin should receive the email for page/post moderation. Admin can publish that page/post.

After this, create a second shortcode or Gutenberg block to show the list of posts which are in pending status for admin approval. Please paginate the entries if there are more than ten.
### Consider following points :-
* You should write very clean and optimized code.
* You must follow the coding standard (WP Coding standards).
* The code should be well documented.

## Requirements
- [Composer](https://getcomposer.org/doc/00-intro.md)
- [Node.js](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [NPM](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [Yarn](https://classic.yarnpkg.com/en/docs/install/#mac-stable)

## Get Started

1. Git Clone to your WordPress plugin folder
```bash
git clone https://github.com/wp-strap/wordpress-plugin-boilerplate.git
```
2. Install node modules
```bash
npm install
```
3. Install Ccomposer Packages
```bash
composer install
```
4. Compile CS, JS files (Webpack)
```bash
yarn dev
```
## Screenshots
![Submission Form](https://rajanvijayan.com/wp-content/uploads/2022/02/screenshot.png)
![Submission List](https://rajanvijayan.com/wp-content/uploads/2022/02/screenshot-2.png)