
```shell
./run-local up --build

# To run in the background, run this:
./run-local up --build -d
```
> You can use the `.env.docker`

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
