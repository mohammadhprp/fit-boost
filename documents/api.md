# API Application Documentation

## Overview

FitBoost's API backend is built with Laravel, a PHP framework known for its robustness and scalability.
The API allows the mobile app to communicate with the server and perform various tasks such as user authentication, data storage and retrieval, and third-party integrations. The API is designed to handle large volumes of traffic, ensuring that the app is fast and responsive.
The backend also includes a database to store user information, workout plans, and meal plans, as well as a server to host the API and manage the app's data. With FitBoost's API backend, developers can build a reliable and secure app that delivers a great user experience.

## Authentication

### Authentication Mechanism

Fit Boost API application uses Bearer Token for authentication.
This requires users to obtain a token from Fit Boost API server after authenticating with their credentials. The token is then sent with each subsequent request as an  
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
    "channel": 1
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

-----

### User Profile

------
> ### ` GET ` `/api/v1/user/profile`

Get logged in user data

#### Response Format

```json  
{
    "id": 1,
    "first_name": "Kuhn",
    "last_name": "Chelsea",
    "phone": "0912356789",
    "email": "evalyn24@example.com",
    "created_at": {
        "human": "16 minutes ago",
        "date_time": "2023-04-02 12:25:07"
    }
}
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized

--------

> ### ` PUT ` `/api/v1/user/profile`

Update user data

#### Request Body

+ first_name (string, nullable)
+ last_name (string, nullable)
+ phone (string, nullable)
+ email (string, email, nullable)

#### Response Format

```json  
{
    "id": 1,
    "first_name": "Kuhn",
    "last_name": "Chelsea",
    "phone": "0912356789",
    "email": "evalyn24@example.com",
    "created_at": {
        "human": "16 minutes ago",
        "date_time": "2023-04-02 12:25:07"
    }
}
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized
+ 422 Unprocessable Content

 ------


### User Workouts

-------

> ### ` GET ` `/api/v1/user/workouts`

Get user workout plans

#### Response Format

```json  
[
    {
        "id": 1,
        "title": "1st Week Workout"
    }
]
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized

 ------

> ### ` GET ` `/api/v1/user/workouts/{id}`

Get workout detail

#### Response Format

```json  
{
    "id": 1,
    "title": "1st Week Workout",
    "items": [
        {
            "workout": {
                "id": 1,
                "name": "Bench Press",
                "raps": 10,
                "sets": 3,
                "weekday": "Monday",
                "level": "intermediate"
            }
        },
        {
            "workout": {
                "id": 2,
                "name": "Squats",
                "raps": 12,
                "sets": 4,
                "weekday": "Wednesday",
                "level": "advanced"
            }
        }
    ],
    "start_at": {
        "human": "2 days ago",
        "date": "2023-04-02"
    },
    "end_at": {
        "human": "4 days from now",
        "date": "2023-04-09"
    },
    "created_at": {
        "human": "1 day ago",
        "date_time": "2023-04-02 12:25:07"
    }
}
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized

 ------

### User Meals

-------

> ### ` GET ` `/api/v1/user/meals`

Get user meal plans

#### Response Format

```json  
[
    {
        "id": 1,
        "title": "1st Month"
    }
]
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized

-------

> ### ` GET ` `/api/v1/user/meals/{id}`

Get meal detail

#### Response Format

```json  
{
    "id": 1,
    "title": "1st Month",
    "items": [
        {
            "meal": {
                "id": 1,
                "name": "Chicken Salad",
                "description": "A healthy salad with grilled chicken, mixed greens, and avocado.",
                "weekday": "AllDay",
                "calories": 350,
                "created_at": "2023-04-02T12:25:07.000000Z",
                "updated_at": "2023-04-02T12:25:07.000000Z"
            }
        },
        {
            "meal": {
                "id": 2,
                "name": "Omelette",
                "description": "A classic breakfast dish with eggs, cheese, and vegetables.",
                "weekday": "Wednesday",
                "calories": 300,
                "created_at": "2023-04-02T12:25:07.000000Z",
                "updated_at": "2023-04-02T12:25:07.000000Z"
            }
        }
    ],
    "start_at": {
        "human": "2 days ago",
        "date": "2023-04-02"
    },
    "end_at": {
        "human": "3 weeks from now",
        "date": "2023-05-02"
    },
    "created_at": {
        "human": "1 day ago",
        "date_time": "2023-04-02 12:25:07"
    }
}
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized


### User Workouts Progress

-------

> ### ` POST ` `/api/v1/user/progress/workout`

Create user workout progress


#### Request Body

- user_workout_id (int, required)
- title (string, nullable)
- description (string, nullable)
- started_at (time, nullable)
- ended_at (time, nullable)

#### Response Format

```json  
{
    "id": 2,
    "title": "day 2",
    "description": "",
    "started_at": {
        "time": "13:30",
        "timezone": {
            "timezone_type": 3,
            "timezone": "UTC"
        }
    },
    "ended_at": {
        "time": "14:35",
        "timezone": {
            "timezone_type": 3,
            "timezone": "UTC"
        }
    }
}
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized
+ 422 Unprocessable Content

-------

> ### ` GET ` `/api/v1/user/progress/workout`

Get list of user workout progress 

#### Response Format

```json  
[
    {
        "id": 1,
        "title": "day 1"
    },
    {
        "id": 2,
        "title": "day 2"
    }
]
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized


-------

> ### ` POST ` `/api/v1/user/progress/workout/`

Create user workout progress

#### Request Body

- user_workout_id (fk, integer, required)
- title (string, nullable)
- description (string, nullable)
- started_at (time, required)
- ended_at (time, required)

#### Response Format

```json  
{
    "id": 1,
    "title": "day 1",
    "description": "65 minutes",
    "started_at": {
        "time": "13:30",
        "timezone": {
            "timezone_type": 3,
            "timezone": "UTC"
        }
    },
    "ended_at": {
        "time": "14:35",
        "timezone": {
            "timezone_type": 3,
            "timezone": "UTC"
        }
    }
}
```  

#### Response Codes

+ 201 Created
+ 401 Unauthorized

-------

> ### ` GET ` `/api/v1/user/progress/workout/{id}`

Get user workout progress detail

#### Response Format

```json  
{
    "id": 1,
    "title": "day 1",
    "description": "",
    "started_at": {
        "time": "13:30",
        "timezone": {
            "timezone_type": 3,
            "timezone": "UTC"
        }
    },
    "ended_at": {
        "time": "14:35",
        "timezone": {
            "timezone_type": 3,
            "timezone": "UTC"
        }
    }
}
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized


-------

> ### ` PUT ` `/api/v1/user/progress/workout/{id}`

Update user workout progress

#### Request Body

- title (string, nullable)
- description (string, nullable)
- started_at (time, nullable)
- ended_at (time, nullable)

#### Response Format

```json  
{
    "id": 1,
    "title": "day 1",
    "description": "65 minutes",
    "started_at": {
        "time": "13:30",
        "timezone": {
            "timezone_type": 3,
            "timezone": "UTC"
        }
    },
    "ended_at": {
        "time": "14:35",
        "timezone": {
            "timezone_type": 3,
            "timezone": "UTC"
        }
    }
}
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized
+ 422 Unprocessable Content


### User Progress

------

> ### ` GET ` `/api/v1/user/progress`

Get list of user progress

#### Response Format

```json  
[
    {
        "id": 2,
        "weight": 80.4
    },
    {
        "id": 1,
        "weight": 81.5
    }
]
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized

-------

> ### ` POST ` `/api/v1/user/progress/{id}`

Create user progress

#### Request Body

- weight (double,required)
- height (integer, required)
- body_fat (double, nullable)
- notes (string, nullable)

#### Response Format

```json  
{
    "id": 2,
    "weight": 80.4,
    "height": 184,
    "body_fat": 23.2,
    "notes": "Day 2/50",
    "created_at": {
        "human": "1 second ago",
        "date_time": "2023-04-18 08:28:39"
    }
}
```  

#### Response Codes

+ 201 Created
+ 401 Unauthorized
+ 422 Unprocessable Content

-------

> ### ` GET ` `/api/v1/user/progress/{id}`

Get user progress detail

#### Response Format

```json  
{
    "id": 1,
    "weight": 81.5,
    "height": 174,
    "body_fat": 23.2,
    "notes": "Day 1/50",
    "created_at": {
        "human": "1 minute ago",
        "date_time": "2023-04-18 08:28:24"
    }
}
```  

#### Response Codes

+ 200 OK
+ 403 Forbidden
+ 401 Unauthorized

-------

> ### ` PUT ` `/api/v1/user/progress/{id}`

Update user progress

#### Request Body

- weight (double,nullable)
- height (integer, nullable)
- body_fat (double, nullable)
- notes (string, nullable)

#### Response Format

```json  
{
    "id": 1,
    "weight": 81.5,
    "height": 184,
    "body_fat": 23.2,
    "notes": "Day - 1/50 - Update",
    "created_at": {
        "human": "5 minutes ago",
        "date_time": "2023-04-18 08:28:24"
    }
}
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized
+ 403 Forbidden
+ 422 Unprocessable Content

-------

> ### ` DELETE ` `/api/v1/user/progress/{id}`

Delete user progress


#### Response Format

```json  

```  

#### Response Codes

+ 204 No Content
+ 401 Unauthorized
+ 403 Forbidden

------ 

### Share Progress

------

> ### ` GET ` `/api/v1/user/share`

Get list of user share progress

#### Response Format

```json  
[
    {
        "id": 2,
        "title": "Day 2 - progress"
    },
    {
        "id": 1,
        "title": "Day 1 - progress"
    }
]
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized

-------

> ### ` POST ` `/api/v1/user/share`

Create user share progress

#### Request Body

- user_progress_id (FK, integer, required)
- title (string, required)
- notes (string, nullable)

#### Response Format

```json  
{
    "id": 3,
    "title": "Day 3 - progress",
    "user_progress": {
        "id": 4,
        "weight": 80.4,
        "height": 184,
        "body_fat": 23.2,
        "notes": "Day 1/50",
        "created_at": {
            "human": "3 days ago",
            "date_time": "2023-04-18 08:28:39"
        }
    },
    "url": "http://localhost/c6uQkI",
    "notes": "Day 3/50",
    "visits_count": 0,
    "created_at": {
        "human": "1 second ago",
        "date_time": "2023-04-22 07:52:41"
    }
}
```  

#### Response Codes

+ 201 Created
+ 401 Unauthorized
+ 422 Unprocessable Content

-------

> ### ` GET ` `/api/v1/user/share/{id}`

Get user share progress detail

#### Response Format

```json  
{
    "id": 3,
    "title": "Day 3 - progress",
    "user_progress": {
        "id": 4,
        "weight": 80.4,
        "height": 184,
        "body_fat": 23.2,
        "notes": "Day 1/50",
        "created_at": {
            "human": "3 days ago",
            "date_time": "2023-04-18 08:28:39"
        }
    },
    "url": "http://localhost/c6uQkI",
    "notes": "Day 3/50",
    "visits_count": 1,
    "created_at": {
        "human": "1 second ago",
        "date_time": "2023-04-22 07:52:41"
    }
}
```  

#### Response Codes

+ 200 OK
+ 403 Forbidden
+ 404 Not Found
+ 401 Unauthorized

-------

> ### ` PUT ` `/api/v1/user/share/{id}`

Update user share progress

#### Request Body

- title (string, nullable)
- notes (string, nullable)

#### Response Format

```json  
{
    "id": 3,
    "title": "Day 3 - progress - updated",
    "user_progress": {
        "id": 4,
        "weight": 80.4,
        "height": 184,
        "body_fat": 23.2,
        "notes": "Day 1/50",
        "created_at": {
            "human": "3 days ago",
            "date_time": "2023-04-18 08:28:39"
        }
    },
    "url": "http://localhost/c6uQkI",
    "notes": "Day 3/50",
    "visits_count": 0,
    "created_at": {
        "human": "1 minute ago",
        "date_time": "2023-04-22 07:52:41"
    }
}
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized
+ 403 Forbidden
+ 404 Not Found
+ 422 Unprocessable Content

-------

> ### ` DELETE ` `/api/v1/user/share/{id}`

Delete user share progress


#### Response Format

```json  

```  

#### Response Codes

+ 204 No Content
+ 401 Unauthorized
+ 403 Forbidden
+ 404 Not Found


### User Workout Reminders

------

> ### ` GET ` `/api/v1/user/userWorkout/{workout_id}/reminder`

Get list of user workout reminders

#### Response Format

```json  
[
    {
        "id": 1,
        "title": "Today workout #2"
    }
]
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized

-------

> ### ` POST ` `/api/v1/user/userWorkout/{workout_id}/reminder`

Create user workout reminder

#### Request Body

- title (string, required)
- description (string, nullable)
- remind_at (date, required)

#### Response Format

```json  
{
    "id": 1,
    "title": "Today workout #2",
    "description": "This is descriptin",
    "remind_at": {
        "human": "1 week ago",
        "date_time": "2023-04-23 17:35:00"
    },
    "is_completed": false,
    "created_at": {
        "human": "1 second ago",
        "date_time": "2023-05-07 08:03:41"
    }
}
```  

#### Response Codes

+ 201 Created
+ 401 Unauthorized
+ 422 Unprocessable Content

-------

> ### ` GET ` `/api/v1/user/userWorkout/{workout_id}/reminder/{id}`

Get user workout reminder detail

#### Response Format

```json  
{
    "id": 1,
    "title": "Today workout #2",
    "description": "This is descriptin",
    "remind_at": {
        "human": "1 week ago",
        "date_time": "2023-04-23 17:35:00"
    },
    "is_completed": false,
    "created_at": {
        "human": "2 minutes ago",
        "date_time": "2023-05-07 08:03:41"
    }
}
```  

#### Response Codes

+ 200 OK
+ 403 Forbidden
+ 404 Not Found
+ 401 Unauthorized

-------

> ### ` PUT ` `/api/v1/user/userWorkout/{workout_id}/reminder/{id}`

Update user workout reminder

#### Request Body

- title (string, nullable)
- description (string, nullable)
- remind_at (date, nullable)
- is_completed (boolean, nullable)

#### Response Format

```json  
{
    "id": 1,
    "title": "Today workout #2",
    "description": "This is descriptin",
    "remind_at": {
        "human": "1 week ago",
        "date_time": "2023-04-23 17:35:00"
    },
    "is_completed": true,
    "created_at": {
        "human": "4 minutes ago",
        "date_time": "2023-05-07 08:03:41"
    }
}
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized
+ 403 Forbidden
+ 404 Not Found
+ 422 Unprocessable Content

-------

> ### ` DELETE ` `/api/v1/user/userWorkout/{workout_id}/reminder/{id}`

Delete user workout reminder

#### Response Format

```json  

```  

#### Response Codes

+ 204 No Content
+ 401 Unauthorized
+ 403 Forbidden
+ 404 Not Found

### User Notifications

------

> ### ` GET ` `/api/v1/user/notifications`

Get list of user notifications

#### Response Format

```json  
[
    {
        "id": 2,
        "title": "Workout time"
    }
]
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized

-------

> ### ` POST ` `/api/v1/user/notifications`

Create user notifications

#### Request Body

- title (string, required)
- description (string, nullable)
- notify_at (date, required)

#### Response Format

```json  
{
    "id": 2,
    "title": "Workout time",
    "description": "This is description",
    "notify_at": "2023-04-23T17:35:00.000000Z"
}
```  

#### Response Codes

+ 201 Created
+ 401 Unauthorized
+ 422 Unprocessable Content

-------

> ### ` GET ` `/api/v1/user/notifications/{id}`

Get user notifications detail

#### Response Format

```json  
{
    "id": 2,
    "title": "Workout time",
    "description": "This is description",
    "notify_at": "2023-04-23T17:35:00.000000Z"
}
```  

#### Response Codes

+ 200 OK
+ 403 Forbidden
+ 404 Not Found
+ 401 Unauthorized

-------

> ### ` PUT ` `/api/v1/user/notifications/{id}`

Update user notifications

#### Request Body

- title (string, nullable)
- description (string, nullable)
- notify_at (date, nullable)

#### Response Format

```json  
{
    "id": 2,
    "title": "Today workout #2",
    "description": "TODO",
    "notify_at": "2023-04-23T17:35:00.000000Z"
}
```  

#### Response Codes

+ 200 OK
+ 401 Unauthorized
+ 403 Forbidden
+ 404 Not Found
+ 422 Unprocessable Content

-------

> ### ` DELETE ` `/api/v1/user/notifications/{id}`

Delete user notifications

#### Response Format

```json  

```  

#### Response Codes

+ 204 No Content
+ 401 Unauthorized
+ 403 Forbidden
+ 404 Not Found
