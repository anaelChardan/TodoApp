#### Blackfire

Blackfire is a tool which helps to do performance tests and profiles.

##### Credentials

You can get the credentials from a Blackfire Account.
There are 4 credentials to get:
- the client id
- the client token
- the server id
- the server token

##### Profiling CLI

```
export BLACKFIRE_CLIENT_ID=client_id
export BLACKFIRE_CLIENT_TOKEN=client_token
export BLACKFIRE_SERVER_ID=server_id
export BLACKFIRE_SERVER_TOKEN=server_token
docker-compose run -u www-data --rm php blackfire run ...
```

##### Profiling HTTP request

```
export BLACKFIRE_CLIENT_ID=client_id
export BLACKFIRE_CLIENT_TOKEN=client_token
export BLACKFIRE_SERVER_ID=server_id
export BLACKFIRE_SERVER_TOKEN=server_token
docker-compose run -u www-data --rm php blackfire curl 'http://httpd/...'
```

Do note that we replaced `localhost` by `httpd` as we are inside the docker.
