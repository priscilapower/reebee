## Backend Take-Home Assignment - Priscila Power

### API
This is an API for manage Flyers and Pages, through users, using the stack with Nginx, PHP and MySQL.


### Getting Started
The first step is to create the development environment by running the following command from this directory:

```
docker-compose -f docker/docker-compose.yml --env-file docker/.env up --build
```

This command will start the service, and the API will be available on the host:

```
http://localhost:8080
```



### Routes:

**To execute the methods POST, PUT and DELETE, you must use Basic Authentication with a pre-created user.**

#### User

##### POST

`POST /user`

Creates a new user.

Header:
```
Token: secret-token
```

Body:
```
{
    "name": "User Name",
    "username": "user4",
    "password": "123"
}
```
The field "name" is not required.


#### Flyer
##### GET
```
GET /flyer
```
Returns all valid flyers.

```
GET /flyer/:id
```
Returns the flyer equivalent to the id.

##### POST
```
POST /flyer
```
Creates a new flyer.

Header:
```
Basic Authentication
```

Body:
```
{
    "name": "flyer 1",
    "storeName": "Store Name",
    "dateValid": "2021-02-10",
    "dateExpired": "2021-02-13",
    "pageCount": 2
}
```
All fields are required.

##### PUT
```
PUT /flyer/:id
```
Updates the flyer specified.

Header:
```
Basic Authentication
```

Body:
```
{
    "name": "flyer 1",
    "storeName": "Store Name",
    "dateValid": "2021-02-10",
    "dateExpired": "2021-02-13",
    "pageCount": 3
}
```
All fields are required.

##### DELETE
```
DELETE /flyer/:id
```
Deletes the flyer specified.

Header:
```
Basic Authentication
```


#### Page
##### GET
```
GET /page/:id
```
Returns the page equivalent to the id.

```
GET /page/flyer/:id
```
Returns all the pages for the flyerId specified ordered by pageNumber.

##### POST
```
POST /page
```
Creates a new page.

Header:
```
Basic Authentication
```

Body:
```
{
    "dateValid": "2021-02-10",
    "dateExpired": "2021-02-14",
    "pageNumber": 1,
    "flyerId": 1
}
```
All fields are required.

##### PUT
```
PUT /page/:id
```
Updates the page specified.

Header:
```
Basic Authentication
```

Body:
```
{
    "dateValid": "2021-02-10",
    "dateExpired": "2021-02-20",
    "pageNumber": 1,
    "flyerId": 1
}
```
All fields are required.

##### DELETE
```
DELETE /page/:id
```
Deletes the page specified.

Header:
```
Basic Authentication
```


**- Thank you -**