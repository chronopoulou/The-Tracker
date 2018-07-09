# The Tracker

The tracker is a laravel project that provides a js code to track website visitors.

The Tracker tracks:
  - Uniqe Visitors
  - URL
  - Browser
  - IP
  - Timestamp

## Tracking mechanism
The Tracker creates a cookie on each website visitor to detect the visitor in the future.

### Browser Detection
To detect the browser The Tracker use the feature detection method and not only the User_Agent

### IP Detection
IP detection is made form the sever side useing the laravel Request 

# Installation
    $ git clone git@github.com:chronopoulou/The-Tracker.git
    $ cd The-Tracker
    $ composer install
    $ php artisan key:generate
    $ php artisan migrate
    $ php artisan db:seed
    $ php artisan serve

##### 1. Login
To login use the following cridentials
- email: admin@admin.com
- pass: admin

##### 2. Create new website

##### 3. Add the JS code to the website you just registerd

If you add the script in a website with https:// protocol you need to serve the application from an https:// protocol also. Otherwise it will be blocked by the browser

# Mailchimp API
Mailchimp api call that import new contact email to a list

#### Endpoint:
| POST | /api/mailchimp/add |
| ------ | ------ |

#### Json Request Fields:
| Key | Description |
| ------ | ------ |
|api_key | You can issue from Mailchimp, Account > Extras > API keys |
|list_id | You can find it at list's Settings > List name and campaign defaults |
|email | The email you want to add |

#### Json Response Fields:
| Key | Description |
| ------ | ------ |
| id | The id of the imported email in the list |
