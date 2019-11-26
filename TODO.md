# Lists
- Double opt-in  - send confirmation email
- Import large lists ( split file and process )
- On contact add option to unsubscribe
- Refactor import and export
- External unsubscrive link
- Number of unsubscribed
- Number of bounced

# Campaigns
- When all mails are sent mark campaign as sent
- Status as consts
- On edit campaign add tracks options
- On duplicate return original links

# Sending
- Attach img for tracking open
- If bounced update record
- If compaint update record
- When sending send only to valid records, escape unsubscribed, bounced and complaint mails
- Sending rate

# Templates
- Implement open template ( preview )

# Reports
- Open report with data
- Test

# Settings
- Add sending method ( AmazonSES, SMTP )

# Auth
- Style all auth pages

# To-Do list
- list_submenu highlight current link
- Responsive
- Translation ???
- Fix migrations add foreign keys and indexes

# Connect to SES and SNS
- Check is there AWS keys
- Email address is not verified
- The security token included in the request is invalid.

# Dashboard
- AWS setup info
- Last campaings
- Statistics

# Bugs
- After registration it redirects to /home which doesn't exist