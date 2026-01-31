# Supply Company System API

## Base URL

```
http://localhost:8000/api/v1
```

## Response Format

All successful responses follow this shape:
```json
{
  "status": "success",
  "data": {}
}
```

Validation failures return HTTP `422` with error details.

## Customer Resource

Fields returned by the API:

```json
{
  "customerID": 1,
  "first_name": "Ahmed",
  "middle_name": "Ali",
  "last_name": "Hassan",
  "address": {
    "house_no": "12",
    "street_name": "King Road",
    "city": "Riyadh",
    "zip_code": "11564"
  },
  "phone": "0551234567",
  "credit_limit": 5000.00,
  "created_at": "2026-01-31 12:00:00",
  "updated_at": "2026-01-31 12:00:00"
}
```

## Endpoints

### List Customers

`GET /customers`

**Response** `200`

```json
{
  "status": "success",
  "data": [
    { "customerID": 1, "first_name": "Ahmed", "middle_name": "Ali", "last_name": "Hassan", "address": { "house_no": "12", "street_name": "King Road", "city": "Riyadh", "zip_code": "11564" }, "phone": "0551234567", "credit_limit": 5000.00, "created_at": "2026-01-31 12:00:00", "updated_at": "2026-01-31 12:00:00" }
  ]
}
```

### Create Customer

`POST /customers`

**Request Body**

```json
{
  "first_name": "Ahmed",
  "middle_name": "Ali",
  "last_name": "Hassan",
  "house_no": "12",
  "street_name": "King Road",
  "city": "Riyadh",
  "zip_code": "11564",
  "phone": "0551234567",
  "credit_limit": 5000.00
}
```

**Validation Rules**

- `first_name`: required
- `middle_name`: required
- `last_name`: required
- `house_no`: required
- `street_name`: required
- `city`: required
- `zip_code`: required
- `phone`: required, unique in `customers`
- `credit_limit`: required, numeric

**Response** `201`

```json
{
  "status": "success",
  "data": { "customerID": 1, "first_name": "Ahmed", "middle_name": "Ali", "last_name": "Hassan", "address": { "house_no": "12", "street_name": "King Road", "city": "Riyadh", "zip_code": "11564" }, "phone": "0551234567", "credit_limit": 5000.00, "created_at": "2026-01-31 12:00:00", "updated_at": "2026-01-31 12:00:00" }
}
```

### Show Customer

`GET /customers/{customerID}`

**Response** `200`

```json
{
  "status": "success",
  "data": { "customerID": 1, "first_name": "Ahmed", "middle_name": "Ali", "last_name": "Hassan", "address": { "house_no": "12", "street_name": "King Road", "city": "Riyadh", "zip_code": "11564" }, "phone": "0551234567", "credit_limit": 5000.00, "created_at": "2026-01-31 12:00:00", "updated_at": "2026-01-31 12:00:00" }
}
```

### Update Customer

`PUT /customers/{customerID}`

**Request Body (partial allowed)**

```json
{
  "phone": "0559998888",
  "credit_limit": 7500.00
}
```

**Validation Rules**

- `first_name`: sometimes|required
- `middle_name`: sometimes|required
- `last_name`: sometimes|required
- `house_no`: sometimes|required
- `street_name`: sometimes|required
- `city`: sometimes|required
- `zip_code`: sometimes|required
- `phone`: sometimes|required, unique in `customers` (ignores current customer)
- `credit_limit`: sometimes|required, numeric

**Response** `200`

```json
{
  "status": "success",
  "data": { "customerID": 1, "first_name": "Ahmed", "middle_name": "Ali", "last_name": "Hassan", "address": { "house_no": "12", "street_name": "King Road", "city": "Riyadh", "zip_code": "11564" }, "phone": "0559998888", "credit_limit": 7500.00, "created_at": "2026-01-31 12:00:00", "updated_at": "2026-01-31 12:00:00" }
}
```

### Delete Customer

`DELETE /customers/{customerID}`

**Response** `204`

```json
{
  "status": "success",
  "data": null
}
```

## Testing

You can use the HTTP client file in the repo:

- `api.http`
