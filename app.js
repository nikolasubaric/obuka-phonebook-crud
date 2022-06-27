var baseUrl = 'http://localhost/phonebook/';
console.log(document.querySelector('#exampleModal'));

async function displayCities() {
  let country_id = document.getElementById('country_id').value;
  let response = await fetch(
    baseUrl + 'getCitiesByCountry.php?country_id=' + country_id
  );
  let cities = await response.json();

  let citiesHTML = '';
  cities.forEach(city => {
    citiesHTML += `
      <option value="${city.id}">${city.name}</option>
    `;
  });

  document.getElementById('city_id').innerHTML = citiesHTML;
}

function cityDeleteModal(id) {
  const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
  const btnDelete = document.getElementById('btn-delete');
  btnDelete.addEventListener('click', () => {
    window.location.href = `deleteCity.php?id=${id}`;
  });
  myModal.show();
}

function countryDeleteModal(id) {
  const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
  const btnDelete = document.getElementById('btn-delete');
  btnDelete.addEventListener('click', () => {
    window.location.href = `deleteCountry.php?id=${id}`;
  });
  myModal.show();
}
