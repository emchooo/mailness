# Lists
- Confirmation mail can be customised

# Campaigns
- On duplicate return original links
- Refactor "track clicks" and "track opens". We need this only if sending from SMTP
- Inlude {{unsubscribe_url}} in campaign
- On send campaign page in earch List show number of contacts

# Sending
- Attach img for tracking open
- Before sending campaign or test mail add warning if creds are not set
- Can't send if content is empty

# Templates
- Implement open template ( preview )

# Frontend
- Style all pages

# General
- If zero user registered /login redirect to /register
- On settings page add option to enable/disable registration

# Database
- Fix migrations add foreign keys and indexes

# Connect to SES and SNS
- Check is there AWS keys
- Email address is not verified
- The security token included in the request is invalid.

# Bugs
- On dashboard it total complaint and bounced are wrong