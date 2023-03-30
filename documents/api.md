# API Application Documentation

## Overview

FitBoost's API backend is built with Laravel, a PHP framework known for its robustness and scalability.
The API allows the mobile app to communicate with the server and perform various tasks such as user authentication, data storage and retrieval, and third-party integrations. The API is designed to handle large volumes of traffic, ensuring that the app is fast and responsive.
The backend also includes a database to store user information, workout plans, and meal plans, as well as a server to host the API and manage the app's data. With FitBoost's API backend, developers can build a reliable and secure app that delivers a great user experience.

## Authentication

### Authentication Mechanism

Fit Boost API application uses Bearer Token for authentication. This requires users to obtain a token from Startup  
Event API server after authenticating with their credentials. The token is then sent with each subsequent request as an  
HTTP header in the following format: Authorization: Bearer [token].


### OTP Authentication

Fit Boost API application also uses OTP with phone number and email for authentication. This involves sending a One-Time  
Password (OTP) to the user's registered phone number via SMS or voice call or email. The user must then enter the OTP to complete  
the authentication process. This provides an additional layer of security to the API and ensures that only authorized  
users can access it.

## Base URL

The base URL for your Fit Boost API application is as follows:

+ Local development environment: <http://localhost:8000/v1>

## Authentication

--------

> ### ` POST ` `/api/v1/auth/otp`

Request for OTP

#### Request Body

+ receiver (string, required)
+ receiver_channel (integer, required)

> Note: For receive OTP with SMS or Call `receiver_channel` most be 1
> And for Email most me 2

#### Response Format

```json  
{  
    "request_id": "c0aeb3e5-1d25-49eb-8fbc-460e348aa78b",
    "cannel": 1,
}  
```  

#### Response Codes

+ 200 OK
+ 422 Unprocessable Content

--------

> ### ` POST ` `/api/v1/auth/user`

Authenticate user with phone number and OTP

#### Request Body

+ receiver (string, required)
+ password (string, required)
+ request_id (string, required)
+ device_name (string, required)

#### Response Format

```json  
{  
    "token": "1|cVvg5wh8XnZJnad1LQKABWhZGQh9pHsa6By3obrs",  
    "action": "create"  
}  
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized
+ 403 Forbidden
+ 422 Unprocessable Content

--------

> ### ` GET ` `/api/v1/auth/logout`

Logout user

#### Response Format

```json  
{  
    "message": "Successfully logged out"  
}  
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized

