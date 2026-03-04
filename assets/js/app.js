document.addEventListener('DOMContentLoaded', function() {
    const serviceSelect = document.getElementById('service');
    const estimatePara = document.getElementById('estimate');

    const prices = {
        'Event': 100,
        'Hotel': 200,
        'Transport': 150,
        'Product': 50
    };

    serviceSelect.addEventListener('change', function() {
        const selectedService = serviceSelect.value; // get value
        if(prices.hasOwnProperty(selectedService)){
            estimatePara.textContent = `Estimated Cost: $${prices[selectedService]}`;
        } else {
            estimatePara.textContent = `Estimated Cost: $0`;
        }
    });
});