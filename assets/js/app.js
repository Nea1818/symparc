import Places from 'places.js'
import Map from './modules/map'

Map.init()

let inputAddress = document.querySelector('#parc_address')
if (inputAddress !== null) {
  let place = Places({
    appId: 'plSOPROSJWXH',
    apiKey: '6b7cf48727803595838cf8a327d9c73b',
    container: inputAddress
  })
  place.on('change', e => {
    document.querySelector('#parc_city').value = e.suggestion.city
    document.querySelector('#parc_postal_code').value = e.suggestion.postcode
    document.querySelector('#parc_lat').value = e.suggestion.latlng.lat
    document.querySelector('#parc_lng').value = e.suggestion.latlng.lng
  })
}

let $ = require('jquery')

require('../css/app.css')

// Supression des photos

document.querySelectorAll('[data-delete]').forEach(a => {
  a.addEventListener('click', e => {
    e.preventDefault()
    fetch(a.getAttribute('href'), {
      method: 'DELETE',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ _token: a.dataset.token })
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          a.parentNode.parentNode.removeChild(a.parentNode)
        } else {
          alert(data.error)
        }
      })
      .catch(e => alert(e))
  })
})

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js')
