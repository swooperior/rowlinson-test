# Rowlinson Knitwear Developer Test

Rowlinson receive a lot of deliveries into the warehouse and keeping track of the status of the orders needs to be 
carefully managed. 

The delivery company, Deliverx, doesn't currently have an API to monitor parcels, they do however send emails through to 
a Rowlinson managed inbox *orders@company.com* which we have programmatic access to.

_Note: Emails from the courier always come from *donotreply@deliverx.co.uk*_

The emails all follow a similar format and examples of which can be found inside `tests/fixtures`

Your task is to create a handler that accepts an email in plain text (as in the tests/fixtures folder) and extracts information 
about the parcel's tracking ID and it's current status.  

Your colleague has already provided `EmailInterface` which will provide a string of the raw email content for you to develop against, 
you do not need to implement these.

## Order Status Types

Status emails should be identified as one of three types:

- `Accepted` - Order has been received by courier
- `Delivered` - Order has been successfully delivered
- `Delivery Failed` - Order delivery was attempted but failed

## Considerations
 
- Anyone can send emails to the inbox as it is public
- Email formats could change at the delivery company's discresion
- More delivery updates could be sent in future

## Implementation

### Part 1

Your implementation should include:

- Implementing `ProcessOrderStatusInterface` interface inside `ProcessOrderStatus` 
- To store the order update call `OrderStatusStorageInterface::store` inside your process method 
- Include a complete set of unit tests for your implementation, some tests are given as an example of usage in `tests/unit`

You do not need to implement any of the other interfaces (`EmailInterface` or `OrderStatusStorageInterface`) these will be implemented by other 
members of your team. 

### Part 2

Sometimes the delivery update emails come in the wrong order. If the order has already been delivered we want to ignore any subsequent
updates about failed or accepted deliveries as they are outdated. 

You can get the current latest status updates by calling `OrderStatusStorageInterface::getCurrentStatus` and passing the tracking ID of the delivery in question. 

## Setup

This barebones of this project have been configured to run on PHP 7.4. 
For ease a Docker compose configuration is included and can be run with the following commands:

- `docker compose up` - Initialise the needed docker images 
- `docker compose run composer install` - Install the application dependencies
- `docker compose run php ./vendor/bin/phpunit tests` - Runs PHPUnit expecting tests in the `./tests` directory
