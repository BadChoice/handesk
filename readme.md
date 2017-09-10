### Handesk

## Description
Handesk has been created by our need (At Revo Systems www.revo.works) to have a powerful yet simple Ticketing system, we needed a system that allowed us to
have multiple teams, with multiple users, easy and efficient reporting by all/team/user as well as lead management.

[Landing page: http://handesk.io](http://handesk.io)

Check out the screenshots to see how nice it looks, and feel fee to contribute by sending us PRs.
We will keep adding features as we need them, but our basic workflow is totally covered :D

## Features
· Email polling (new tickets and tickets updates)    
· Email attachments as ticket attachments (using laravel storage driver)
· API for creating/updating/fetching tickets/leads so you can display them into your main app    
· Instant email/slack notifications when tickets are created/updated   
· Everything is unlimited    
· Lead management (With its API as well)   
· Auto lead subscription to mailchimp based on its tags   
· Tickets reporting   
· Tickets internal notes   
· Tickets can be escalated, so assistants can comment on them to help the teams   
· Can merge tickets       
· Lead tasks, that can have a due date, and sending daily tasks email   
· Create issues to your code repository directly from the ticket   
· UI multi language support (default en, alternativ ca, de, fr, es)

> Follow us on twitter @codepassion to stay tuned

## Installation
Its very simple, you just need to follow the standard Laravel installation

```shell
git clone https://github.com/BadChoice/handesk.git
composer install
# Setup your .env file to match you desired database
php artisan key:generate
php artisan migrate --seed
php artisan storage:link #if you use the local driver
```

Alternatively, you can run the entire setup locally by running the following on your computer

```shell
./run-local up --build

# To run in the background, run this:
./run-local up --build -d
```

## Using xdebug for local development
These guidelines are for PHPSTORM
* Find the command that works for your specific OS or manually input your local IP address in this line in `run-local`; `export XDEBUG_HOST=$(ipconfig getifaddr en0) # Specific to MacOS [export XDEBUG_HOST=$(ip -o -4 addr list ppp0 | awk '{print $4}' | cut -d/ -f1) # Specific to Linux distros]`
* Set the debug port in PHPSTORM to 9005 as seen in `scripts/xdebug.ini`
* Create a new server and map the path on your host machine to the exact path on your docker container e.g /Library/WebServer/Documents/handesk -> /var/www/html/handesk
* Go to RUN/Edit Configurations... within the IDE and click on the `+` icon to create a new config. Choose PHP Remote Debug
* Use the docker-server you created in step three and input `PHPSTORM` as the IDE KEY.
* Startup the containers using `./run-local up --build` and start listening for connections

## SSL Setup in production
* Edit the `.env.nginx` file to contain the domain that points to your server and application. Edit the email variable also
* In `nginx/conf/default.conf`, edit the `server_name` directive and use your server name. This should be the same as the domain you put in the first step


> The default admin user is admin@handesk.com / admin
> If you want email pulling, you need to enable the `imap` extension on php (note that on mac the php-cli runs very slow, you need to update your /etc/hosts file 

```
::1         localhost YourMac.local
127.0.0.1   localhost YourMac.local
```

Open your `app/Console/Kernel.php` to update the schedulers as you want (comment them if not needed)
Add the cron job `* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1`


### Further configuration
#### Email pulling
Enter your mail credentials in .env

````
MAIL_FETCH_HOST=pop3.handesk.com   
MAIL_FETCH_PORT=110   
MAIL_FETCH_USERNAME=hello@handesk.com   
MAIL_FETCH_PASSWORD=secret-password   
````

#### Mailchimp
Set your mailchimp key in .env
`MAILCHIMP_API_KEY=448027f3acac5594605be3adf78be862-us15`

And enter the relation of `tags => list` id in `config/services.php` mailchimp section

#### Bitbucket
You can create issues directly to your code repository from tickets. You need to setup your credentials in the .env
```
BITBUCKET_USER=bitbucket-user-if-using-basic-auth
BITBUCKET_PASSWORD=bitbucket-password-if-using-basic-auth
```

And enter your repositories list in `config/issues.php` file, filling the `repositories` field. 

#### Api Token
Set your desired API token in the .env

```API_TOKEN=the-api-token```

There is the `badchoice/handesk-php` package in packagist to easily talk with the api.


### Screenshots
![Tickets screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/tickets.png)
![Ticket screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/ticket.png)
![Leads screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/leads.png)
![Lead screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/lead.png)
![Invitation screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/invitation.png)
![Email screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/email.png)


## Development
We try to follow a TDD approach as well as some mixed functional CSS for the frontend.
   
PRs are welcome!
 

