document.addEventListener('DOMContentLoaded', () => {
  const radios = document.querySelectorAll('input[name="radioPrice"]');
  const nbrPersonField = document.getElementById('booking_nbrPerson');
  const container = document.getElementById('participants-fields')
  const rateDiscount = document.getElementById('booking_rateDiscount');
  const netPrice = document.getElementById('booking_netPrice');
  const grossPrice = document.getElementById('booking_grossPrice');
  const netTotal = document.getElementById('booking_netTotal');

  if (!nbrPersonField || !container) {
    console.warn('Champ nbrPerson ou conteneur participants non trouvé');
    return;
  }

  radios.forEach(radio => {
    radio.addEventListener('click', () => {
      const personCount = radio.dataset.person;
       if (personCount) {
        console.log(`→ Mise à jour du champ avec ${personCount}`);
        nbrPersonField.value = personCount;
        rateDiscount.value   = radio.dataset.rate;
        netPrice.value       = grossPrice.value*(1 - rateDiscount.value/100);
        netTotal.value       = netPrice.value*nbrPersonField.value;
        generateParticipantsFields(personCount);
      }
    });

    // Initialiser avec le bouton déjà coché
    if (radio.checked) {
      const personCount = radio.dataset.person;
      if (personCount) {
        nbrPersonField.value = personCount;
      }
    }
  });

  nbrPersonField.addEventListener('change', () => {
    generateParticipantsFields(nbrPersonField.value);
  });

  
  function generateParticipantsFields(nbrField) {

    container.innerHTML = '';

    const number = parseInt(nbrField, 10);
    if (isNaN(number) || number <= 0)  {
        return;
    }

    for (let i = 2; i<= number; i++) {
        const div  = document.createElement('div');
        div.classList.add('mb-2');

        const label = document.createElement('label');
        label.setAttribute('for', `participant-${i}`);
        label.classList.add('form-label');
        label.innerText = `Nom de la personne-${i}`;

        const input = document.createElement('input');
        input.type  = 'text';
        input.name  = 'participantsNames[]';
        input.id    = `participant-${i}`;
        input.classList.add('form-control');
        input.placeholder = `Nom complet de la personne-${i}`;
        input.required = true;

        div.appendChild(label);
        div.appendChild(input);
        container.appendChild(div);
    }
  }


});