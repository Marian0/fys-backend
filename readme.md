# Find your Service Coding Challenge

## The exercise 
We want a web app that allows consumers to search for services. Each service offered has the following fields:
- id
- title
- description
- address
- city
- state
- zip code
- geolocation - latitude
- geolocation - longitude

### Admin section
After logging in with your email and password, the administrator will see a table listing all services offered. The table will have a link to edit or remove each entry.
The dashboard will also have the ability to add a new service offered.
When entering / editing a service offered, the user will enter his address, and the remaining information (city, state, zip, geolocation) will be autocompleted using Google Place Autocomplete Form:
Sample:
https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-a ddressform

### Public Site

The public site will start showing a search input and a distance dropdown which values will be (1km, 2km, 5km, 10km, 25km, 50km, 100km, anywhere)
If browser Geolocation is granted, it will be look for locations near given lat and long. The distance dropdown should be forced to "Anywhere" if the user does not approve Browser's Geolocation.

On submit, it will list all services available in the search radius selected, where the search text string is contained in the posting title.
How we will score it

#### What it needs to do:
- Work properly, bugless
- Code must be clean and readable.
- Readme.md with clear installation notes. - Stored in a Git repository
#### What it would be good to have:
- DocBlock / DocComment on every function written
- Good looking code
- Good looking site, no need to do a fancy design, but a clean and usable app. Bootstrap, Material, or any boilerplate works.
- Passing tests
- Docker setup
- Migrations
- Use of Vue or React

## Backend Installation
- Clone this repository
- run `composer install`
- run `docker-compose up`

## Author
Mariano Peyregne