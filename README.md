# Installation
## Using Docker
1. Download the project and extract files. 
2. Edit `Docekrfile` and `docker-compose.yml` by preference
3. Open a terminal or command prompt and navigate to your project directory.
4. Type following command
	```
		docker-compose up -d
	```
5. Make sure new container is running in the desktop client or using `docker-compose ps`.
6. Verify by navigating to `http://localhost:8080` or other if specified in `docker-compose.yml`.

## Setting up on your server
1. Download the project and extract files, or use `git clone`
2. Set up database settings in `/interface/settings.php`
3. If the project is **not** located at the **document root**, you'll need to specify path in the `/lib/ShortLink/class.php` on line 1 and `/lib/RouteEngine/RouteManager.php` on line 1.

**Important**: your Apache has to have mod_rewrite module.

# Usage
This service is a simple link shortening service built with PHP. It allows user to shorten URLs. Accessing that link redirects user to the original URL.

### Submit a URL
1. Navigate to the website (or localhost).
2. Enter the URL you want to shorten into the input field (excludes non-http URLs).
3. Click the "Go" button.
- If you enter the URL that was already shortened before, you'll get corresponding message and it's shortened link, as well as the number of times this URL was accessed.

### Get Shortened Link
- After submitting the URL, the shortened link will be displayed on the website.

### Access Shortened Link
- Accessing the link will redirect you to the original URL. Trying to access wrong link would cause 404 Not found error.

### Example Usage
1. Submitting a URL:
   - Input: `https://en.wikipedia.org/wiki/Coup_de_grâce`
   - Output: `Shortened link: https://yoursite/e123`

2. Accessing Shortened Link:
   - Visit `https://yoursite/e123` in your browser to be redirected to the original URL.
