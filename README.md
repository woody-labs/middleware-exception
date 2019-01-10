# Middleware Exception

This middleware catch any exception thrown by deeper middleware.

For `HttpException`, a response with its code and message is created.
For any other exception, an `Internal Error` is returned.


## Implementation

Just add the middleware into your `dispatcher` pipeline at a nested level to catch any exception of deepest middleware.

````php
// @todo: generate request

$dispatcher = new Dispatcher();
$dispatcher->pipe(new CorrelationIdMiddleware());
$dispatcher->pipe(new ExceptionMiddleware());
$dispatcher->pipe(new MyAddMiddleware());

// @todo: add other middleware

$response = $dispatcher->handle($request);
````

