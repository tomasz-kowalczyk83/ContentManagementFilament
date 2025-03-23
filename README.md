# Project codename: tbd

---

## Phase 1
basic setup for Region Subregion Country State and City including resources, relationships, database seeders etc (based mostly on )

filament CRUD setup

Airports, airlines, ports and train stations locations seeded and linked to City records, 

Filament CRUD including file uploads and geolocations

Channel setup including CRUD and assigning locations, currencies and languages

Multitenancy to create sales channels in different scopes
## Phase 2
Advanced techniques for performacne and storage optimisation

* Eager loading, caching and denormalisation
* Database systems to consider:
    * PostgreSQL - JSONB support, materialized views, recursive queries
    * MongoDB - excels at hierarchial and nested data
    * Elasticsearch - excels at fulltext search and aggregations
    * Graph database (Neo4j) - excels modeling complex relationships and traversing hierarchies
