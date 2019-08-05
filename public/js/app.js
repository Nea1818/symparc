import Places from 'places.js'

let inputAddress = document.querySelector('#parc_address')
if (inputAddress !== null) {
  let place = Places({
    container: inputAddress
  })
  place.on('change', e => {
    document.querySelector('#parc_city').value = e.suggestion.city
    document.querySelector('#parc_postal_code').value = e.suggestion.postcode
    document.querySelector('#parc_lat').value = e.suggestion.latlng.lat
    document.querySelector('#parc_lng').value = e.suggestion.latlng.lng
  })
}

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
