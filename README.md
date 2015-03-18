# php-mst

Uses Google maps api to find a minimum spanning tree of a list of cities

## What it does

Given a list of cities, it uses the [Google directions api] (https://developers.google.com/maps/documentation/directions/) to calculate the distances from each city to every other city.

It then takes that and uses Prims to calculate the minimum spanning tree of all those cities.

