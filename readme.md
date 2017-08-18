### Handesk

## Description
Handesk has been created by our need (At Revo Systems www.revo.works) to have a powerful yet simple Ticketing system, we needed a system that allowed us to
have multiple teams, with multiple users, easy and efficient reporting by all/team/user as well as lead management.

Check out the screenshots to see how nice it looks, and feel fee to contribute by sending us PRs.
We will keep adding features as we need them, but our basic workflow is totally covered :D

## Features
· Email polling (new tickets and tickets updates)    
· API for creating/updating/fetching tickets/leads so you can display them into your main app    
· Instant email/slack notifications when tickets are created/updated   
· Everything is unlimited    
· Lead management (With its API as well)   
· Auto lead subscription to mailchimp based on its tags   
· Tickets reporting   
· Tickets internal notes   
· Can merge tickets       
· Lead tasks, that can have a due date, and sending daily tasks email

## Installation
Its very simple, you just need to follow the standard Laravel installation
```
git clone https://github.com/BadChoice/handesk.git
composer install
php artisan key:generate
# Setup your .env file to match you desired database
php artisan migrate --seed
```

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
MAIL_FETCH_HOST=pop3.codepassion.io   
MAIL_FETCH_PORT=110   
MAIL_FETCH_USERNAME=hello@codepassion.io   
MAIL_FETCH_PASSWORD=mypassion!25   
````

#### Mailchimp
Set your mailchimp key in .env
`MAILCHIMP_API_KEY=448027f3acac5594605be3adf78be862-us15`

And enter the relation of `tags => list` id in `app/config/services.php` mailchimp section

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

