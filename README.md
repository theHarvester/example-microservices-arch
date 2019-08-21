# Example Microservice Architecture

#### Completed Endpoints

- GET http://0.0.0.0:8080/pet
- GET http://0.0.0.0:8080/pet/findByStatus
- GET http://0.0.0.0:8080/pet/{id}

#### Incomplete Endpoints

 - POST /pet
 - PUT /pet
 - POST /{id}
 - DELETE /{id}
 - POST /{id}/uploadImage

This is a basic example of a Microservice in PHP. I've used the Slim framework as the base. I've chosen Slim because it's just a router / container which will make it easier to distinguish my code from the framework. The small amount of auto-gen code it produces is quite well done and easy to extend.

Because of the simplicity of this service, I have not been able to show the following concepts:

1. Dispatch async events to some sort of event bus
2. Separate writes from reads (CQRS)
3. Implement circuit breaker pattern to gracefully handle when services are down

### Anatomy of a read request

I've assumed that the resource permissions will be applied before fetching the data from this service. So I won't cover any search restriction code in this example.

A read request will take the following steps:

1. Safely apply search filters
2. Fetch data from repository
3. Transform the response into a nice API response (usually I'd use the Fractal library but the source API docs do not have pagination so there's no point)

### Anatomy of a write request

A write request will have the following duties to perform during the life of the request.

1. Validation
2. Write to a log table (useful for diagnostics or a history feature)
3. Create/Update the state in the main read table
4. Emit an event so other services can use that information (Kafka, SNS + SQS, etc.)
5. Return response code

### Other notes

I've kept the database interaction logic very simple. There's plenty of packages that can do it with plenty of depth but that's not where I'm going to put my effort for this example.

## Run the application

You can use `docker-compose` to run the app:
```bash
cp .env.example .env
composer install
docker-compose up -d
```
After that, open `http://0.0.0.0:8080` in your browser or with Postman.