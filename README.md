# WebGIS - Italian Public Parks and Gardens

An interactive WebGIS application developed to explore public parks and gardens across Italy using clustered spatial points.

## 📌 Overview
This project was created as a final practical examination for the *"WebGIS and Spatial Databases"* module (part of the Level II Master in Geomatics at the Center for Geo-Technologies - University of Siena, academic year 2026). It demonstrates the integration of open-source mapping libraries with custom spatial data processing workflows.

## 🚀 Key Features
* **Interactive Map:** Built with Leaflet, featuring OpenStreetMap basemaps and marker clustering (`leaflet.markercluster`) for optimized rendering of thousands of spatial points.
* **Tabular Archive:** A searchable and interactive table view allowing users to inspect records and zoom directly to specific locations on the map.
* **Dynamic Endpoints:** PHP backend handling asynchronous data retrieval from structured CSV datasets.
* **Geodetic Specifications:** Strict adherence to spatial reference systems (WGS 84 / EPSG:4326 for point features; Web Mercator / EPSG:3857 for map tiles).

## 🛠️ Built With
* **HTML5 / CSS3 / JavaScript** – Frontend layout and client-side logic.
* **PHP** – Backend endpoint for dataset parsing and JSON serialization.
* **Leaflet.js** – Open-source JavaScript library for interactive maps.
* **Leaflet.markercluster** – Plugin for marker clustering performance.

## 📂 Data Source
The spatial dataset (`Parchi_E_Giardini.csv`) originates from community-collected GPS data via [POIGPS](https://www.poigps.com/). *Note: The data is intended for demonstration purposes and may not be exhaustive or fully updated.*

## 👤 Author
* **Renato Forte** – GIS Analyst & Geomatics Master's Student at CGT, University of Siena.
