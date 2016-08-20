WPPSniffStorage
===============

WPP Sniff storage.

Credentials are stored at pair.txt

Default credentials: root / toor

tolower(username):sha1(salt + upper(user) + ":" + upper(pass) + salt) to generate new credentials.
