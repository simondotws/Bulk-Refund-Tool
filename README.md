# GoCardless Bulk Refund Tool

This is a script that will allow you to refund all payment ID's either fully or partially from a json file.

## Installation

Download repository and run composer to download required libraries:
```bash
composer install
```

Create your .env file:
```bash
touch .env
```

Format your .env file as follows:
```bash
GC_ACCESS_TOKEN=YOUR ACCESS TOKEN
INTERVAL=2
```
(You can get your access token [here](https://developer.gocardless.com/getting-started/api/making-your-first-request/#creating-an-access-token). The interval is the time between requests to prevent you hitting the API limit if your data file is large).

## Usage

Make sure your data.json file is in the main directory and is formatted as below then launch run.php.

```json
[
  {
    "payment_id": "PM00327TS59DHF",
    "amount": 999,
    "total_amount_confirmation": 999
  },
  {
    "payment_id": "PM00327TS59ABC",
    "amount": 4067,
    "total_amount_confirmation": 5000
  },
]
```
Once the file has completed running a list will be returned and json file generated (completed.json) to return the actions that were performed on your GoCardless account.

```json
[
  {
    "payment_id": "PM00327TS59DHF",
    "refund_id": "RF00004DR019DB",
    "result": "SUCCESS",
    "amount": 999,
    "message": null
  },
  {
    "payment_id": "PM00327ZFVAA2H",
    "refund_id": null,
    "result": "ERROR",
    "amount": null,
    "message": "The total amount confirmation given did not equal the actual total amount"
  }
]
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
