
# Theracure Api

These are the api used in theracure application, they're created with php with a jwt authentication and a good routing using an mvc architecture

## API Reference

#### Login

```http
  POST /Theracure/authenticate
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | **Required**. Your API key |
| `password` | `string` | **Required**. Your API key |

#### Signup

```http
  POST /Theracure/users/signup
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name`      | `string` | **Required**. Name of user |
| `birthday`      | `date` | **Required**. Birthday of user |
| `cin`      | `string` | **Required**. Cin of user |
| `email`      | `string` | **Required**. Email of user |
| `password`      | `string` | **Required**. Password of user |
| `img`      | `string` | **Required**. Image of user |

#### Get All doctors

```http
  GET /Theracure/doctors/getAllDoctors
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of doctors |
| `name`      | `string` | **Required**. Name of doctors |
| `birthday`      | `date` | **Required**. Birthday of doctors |
| `cin`      | `string` | **Required**. Cin of doctors |
| `email`      | `string` | **Required**. Email of doctors |
| `password`      | `string` | **Required**. Password of doctors |
| `img`      | `string` | **Required**. Image of doctors |
| `speaciality`      | `string` | **Required**. Speaciality of doctors |

#### Update user

```http
  PUT /Theracure/users/update
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | **Required**. Name of user |
| `birthday`      | `date` | **Required**. Birthday of user |
| `cin`      | `string` | **Required**. Cin of user |
| `email`      | `string` | **Required**. Email of user |
| `password`      | `string` | **Required**. Password of user |
| `img`      | `string` | **Required**. Image of user |

#### Take appointment

```http
  POST /Theracure/appointments/takeAppointment/${userId}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `userId`      | `integer` | **Required**. Id of authenticated user |
| `date`      | `date` | **Required**. date of appointment |
| `schedule_id`      | `integer` | **Required**. Id of time of appointment |

#### Cancel appointment

```http
  DELETE /Theracure/appointments/cancelAppointment/${schedule_id}/${appointment_id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `$schedule_id`      | `integer` | **Required**. Id of schedule taken |
| `appointment_id`      | `integer` | **Required**. Id of appointment |

#### Get single appointment

```http
  POST /Theracure/appointments/getSingleAppointment/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of appointment |
| `date`      | `date` | **Required**. date of appointment |
| `time`      | `string` | **Required**.  Time of appointment |




## Tech Stack

**Client:** ReactJs, CSS

**Server:** PHP

**Server:** MVC

**Authentication:** JWT


## Feedback

If you have any feedback, please reach out to me at ahmedennaime20@gmail.com or on Linkedin Ahmed Ennaime.


## Support

For support, email ahmedennaime20@gmail.com or reach me in Linkedin Ahmed Ennaime.

