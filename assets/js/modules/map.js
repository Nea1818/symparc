import L from 'leaflet'

export default class Map {
  static init() {
    let map = document.querySelector('#map')
    if (map === null) {
      return
    }

    let center = [map.dataset.lat, map.dataset.lng]

    map = L.map('map').setView(center, 15)
    let token =
      'pk.eyJ1IjoibmVhZGV2IiwiYSI6ImNqeXl0OHNlZjA2N3czYm1ydTZ6a3hmbzEifQ.3h0rWIayhfhXyY3IMezQpQ'
    L.tileLayer(
      `https://api.mapbox.com/v4/mapbox.streets/{z}/{x}/{y}.png?access_token=${token}`,
      {
        maxZoom: 19,
        minZoom: 12,
        attribution:
          '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>'
      }
    ).addTo(map)
    L.marker(center).addTo(map)
  }
}
