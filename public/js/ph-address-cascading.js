// PH Address Cascading Dropdowns - Professional Implementation
// Features: Cascading region→province→city, parse existing address, validation, preview

let phAddressData = null;

async function initPhAddressCascading(container = document) {
  const regionSelect = container.querySelector('#region');
  const provinceSelect = container.querySelector('#province');
  const citySelect = container.querySelector('#city');
  const barangayInput = container.querySelector('#barangay');
  const streetInput = container.querySelector('#street');
  const addressField = container.querySelector('#address');
  const previewDiv = container.querySelector('#address-preview');

  if (!regionSelect) return console.warn('Address fields not found');

  try {
    const response = await fetch('/js/ph-addresses.json');
    if (!response.ok) throw new Error('JSON load failed');
    phAddressData = await response.json();

    // Populate regions
    phAddressData.regions.forEach(region => {
      const option = new Option(region.name, region.code);
      regionSelect.appendChild(option);
    });

    // Event listeners
    regionSelect.addEventListener('change', () => populateProvince(provinceSelect, citySelect));
    provinceSelect?.addEventListener('change', () => populateCity(citySelect));
    [regionSelect, provinceSelect, citySelect, barangayInput, streetInput].forEach(el => 
      el?.addEventListener('change', updateAddress)
    );
    [barangayInput, streetInput].forEach(el => el?.addEventListener('input', updateAddress));

    // Prefill if data available (profile edit)
    const existingAddress = addressField.dataset.prefill || addressField.value;
    if (existingAddress) {
      await parseAndPrefillAddress(existingAddress, regionSelect, provinceSelect, citySelect, barangayInput, streetInput);
    }

  } catch (error) {
    console.error('PH Address init failed:', error);
    showError(container, 'Address data unavailable. Enter manually.');
  }
}

function populateProvince(provinceSelect, citySelect) {
  const regionCode = document.getElementById('region').value;
  provinceSelect.innerHTML = '<option value=\"\">Loading provinces...</option>';
  provinceSelect.disabled = true;
  citySelect.innerHTML = '<option value=\"\">Select City</option>';
  citySelect.disabled = true;

  if (!regionCode || !phAddressData) return;

  const region = phAddressData.regions.find(r => r.code === regionCode);
  provinceSelect.innerHTML = '<option value=\"\">Select Province</option>';
  if (region) {
    region.provinces.forEach(prov => {
      const option = new Option(prov.name, prov.code);
      provinceSelect.appendChild(option);
    });
    provinceSelect.disabled = false;
  }
}

function populateCity(citySelect) {
  const provinceCode = document.getElementById('province').value;
  const regionCode = document.getElementById('region').value;
  citySelect.innerHTML = '<option value=\"\">Loading cities...</option>';
  citySelect.disabled = true;

  if (!provinceCode || !regionCode || !phAddressData) return;

  const region = phAddressData.regions.find(r => r.code === regionCode);
  if (region) {
    const province = region.provinces.find(p => p.code === provinceCode);
    citySelect.innerHTML = '<option value=\"\">Select City/Municipality</option>';
    if (province && province.cities) {
      province.cities.forEach(city => {
        const option = new Option(city.name, city.code);
        citySelect.appendChild(option);
      });
      citySelect.disabled = false;
    }
  }
}

function updateAddress() {
  const regionEl = document.getElementById('region');
  const provinceEl = document.getElementById('province');
  const cityEl = document.getElementById('city');
  const barangay = document.getElementById('barangay')?.value.trim() || '';
  const street = document.getElementById('street')?.value.trim() || '';
  const addressField = document.getElementById('address');
  const preview = document.getElementById('address-preview');

  const region = regionEl.options[regionEl.selectedIndex]?.text || '';
  const province = provinceEl.options[provinceEl.selectedIndex]?.text || '';
  const city = cityEl.options[cityEl.selectedIndex]?.text || '';

  const fullAddress = [region, province, city, barangay, street].filter(Boolean).join(', ');
  addressField.value = fullAddress;

  if (preview) {
    preview.textContent = fullAddress || 'Address will appear here...';
    preview.className = fullAddress.length > 20 ? 'form-text text-success small' : 'form-text text-muted small';
  }

  validateAddressFields();
}

function parseAndPrefillAddress(addressString, regionSelect, provinceSelect, citySelect, barangayInput, streetInput) {
  const parts = addressString.split(',').map(p => p.trim()).reverse();
  const street = parts[0] || '';
  const barangay = parts[1] || '';
  const cityName = parts[2] || '';
  const provinceName = parts[1] || parts[3] || '';
  const regionName = parts[4] || '';

  // Try to match city first (most specific)
  let foundCity = null, foundProvince = null, foundRegion = null;
  for (const region of phAddressData.regions) {
    if (region.name.includes(regionName) || regionName.includes(region.name)) {
      foundRegion = region;
      for (const prov of region.provinces) {
        if (provinceName.includes(prov.name) || prov.name.includes(provinceName)) {
          foundProvince = prov;
          for (const city of prov.cities) {
            if (city.name.includes(cityName) || cityName.includes(city.name)) {
              foundCity = city;
              break;
            }
          }
          if (foundCity) break;
        }
      }
      if (foundCity) break;
    }
  }

  // Set values
  if (foundRegion) {
    regionSelect.value = foundRegion.code;
    populateProvince(provinceSelect, citySelect);
    setTimeout(() => {
      if (foundProvince) provinceSelect.value = foundProvince.code;
      populateCity(citySelect);
      setTimeout(() => {
        if (foundCity) citySelect.value = foundCity.code;
        if (barangayInput) barangayInput.value = barangay;
        if (streetInput) streetInput.value = street;
        updateAddress();
      }, 100);
    }, 100);
  }
}

function validateAddressFields() {
  const fields = ['#region', '#province', '#city', '#barangay', '#street'];
  let validCount = 0;
  fields.forEach(selector => {
    const el = document.querySelector(selector);
    if (el && el.value.trim()) validCount++;
  });

  const completeness = validCount / 5 * 100;
  const statusEl = document.querySelector('#address-status');
  if (statusEl) {
    statusEl.textContent = `Address completeness: ${completeness}%`;
    statusEl.className = completeness >= 80 ? 'text-success' : completeness >= 50 ? 'text-warning' : 'text-danger';
  }
}

function showError(container, message) {
  const errorDiv = document.createElement('div');
  errorDiv.className = 'alert alert-warning small mb-2';
  errorDiv.innerHTML = `<i class=\"bi bi-exclamation-triangle\"></i> ${message}`;
  container.querySelector('.mb-4')?.prepend(errorDiv);
}

// Global init on DOM load
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-init-address]').forEach(el => {
    initPhAddressCascading(el.closest('.address-section') || document);
  });
});

// Export for blade usage
window.phAddress = { initPhAddressCascading, updateAddress };
