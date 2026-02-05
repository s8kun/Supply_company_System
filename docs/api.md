# Supply Company System API

Base URL:
```
http://localhost:8000/api/v1
```

All successful responses follow this shape:
```json
{
  "status": "success",
  "data": {}
}
```

Validation errors return HTTP `422` with details.

## Status Values

OrderStatus:
- `pending`
- `processing`
- `completed`
- `cancelled`

DeliveryStatus:
- `pending`
- `delivered`

## Customers

### List customers
`GET /customers`

### Create customer
`POST /customers`

Body (JSON):
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

### Show customer
`GET /customers/{customerID}`

### Update customer
`PUT /customers/{customerID}`

Body (JSON, partial allowed):
```json
{
  "phone": "0559998888",
  "credit_limit": 7500.00
}
```

### Delete customer
`DELETE /customers/{customerID}`

## Products

### List products
`GET /products`

### Create product
`POST /products`

You can send JSON without images:
```json
{
  "name": "Samsung Galaxy A55",
  "description": "Smartphone with 5G, 128GB storage, and 8GB RAM",
  "costPrice": 950.00,
  "sellPrice": 1200.00,
  "currentQuantity": 50,
  "reorderLevel": 10,
  "reorderQuantity": 30
}
```

Or send multipart with 3–4 images:
```
name=Samsung Galaxy A55
description=Smartphone with 5G, 128GB storage, and 8GB RAM
costPrice=950.00
sellPrice=1200.00
currentQuantity=50
reorderLevel=10
reorderQuantity=30
images[]=@/path/to/image1.jpg
images[]=@/path/to/image2.jpg
images[]=@/path/to/image3.jpg
```

### Show product
`GET /products/{productID}`

### Update product
`PUT /products/{productID}` (or `PATCH`)

If you send `images[]`, existing images are replaced.

### Delete product
`DELETE /products/{productID}`

## Orders

### List orders
`GET /orders`

### Create order
`POST /orders`

Body (JSON):
```json
{
  "customerID": 1,
  "dueDate": "2026-02-10",
  "items": [
    { "productID": 1, "quantity": 2 },
    { "productID": 2, "quantity": 1 }
  ]
}
```

Notes:
- `totalPrice` is calculated server-side.
- Customer credit is decreased by the order total.

### Show order
`GET /orders/{orderID}`

### Update order
`PATCH /orders/{orderID}`

Body (JSON, partial allowed):
```json
{
  "dueDate": "2026-02-12",
  "isPaid": false
}
```

### Cancel order
`POST /orders/{orderID}/cancel`

Rules:
- Cancellation allowed only if no items are delivered.
- Credit is restored.
- Inventory is not changed (stock is reduced only on delivery).

### Delete order
`DELETE /orders/{orderID}`

## Order Items

### List order items
`GET /order-items`

### Show order item
`GET /order-items/{orderItemID}`

### Deliver order item
`PATCH /order-items/{orderItemID}`

Body (JSON):
```json
{
  "deliveryStatus": "delivered"
}
```

## Redeem Codes

### Create redeem code
`POST /redeem-codes`

Body (JSON):
```json
{
  "amount": 150.00
}
```

### Redeem code
`POST /redeem-codes/redeem`

Body (JSON):
```json
{
  "customerID": 1,
  "code": "PASTE_CODE_HERE"
}
```

Notes:
- Codes are single-use.
- Reusing a code returns a validation error.
