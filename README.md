# Example Microservice Architecture

This is a basic example of a Microservice in PHP. I've used the Slim framework as the base. I've chosen Slim because it's just a router / container which will make it easier to distinguish my code from the framework.

I'll attempt to keep the scaffolding code light but hit the core concepts when deploying microservices into production. In particular, this service should implement the following patterns:

1. Dispatch async events to some sort of event bus
2. Separate writes from reads (CQRS)
3. Implement circuit breaker pattern to handle when services are down

### Anatomy of a write request

A write request will have the following duties to perform during the life of the request.

1. Validation
2. Write to a log table (useful for diagnostics or a history feature)
3. Create/Update the state in the main read table
4. Emit an event so other services can use that information
5. Return response code

The event emitter code will simply write to a log file for this example. In production I would probably lean towards using kafka or SNS + SQS for the event log.

### Anatomy of a read request

I've assumed that the resource permissions will be applied before fetching the data from this service. So I won't cover any search restriction code in this example.

A read request will take the following steps:

1. Safely apply search filters
2. Fetch data from repository
3. Transform the response into a nice API response (Fractal library)

### Other notes

I'm just going to keep the validation and database interaction logic very light. There's plenty of packages that can do it with plenty of depth but that's not where I'm going to put my effort for this example.

## Run the application

You can use `docker-compose` to run the app:
```bash
docker-compose up -d
```
After that, open `http://0.0.0.0:8080` in your browser or with Postman.

`TODO Add Postman collection of working routes`
