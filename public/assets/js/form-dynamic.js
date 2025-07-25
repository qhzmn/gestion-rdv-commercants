document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const extraFieldsContainer = document.getElementById('extraFields');

    typeSelect.addEventListener('change', function () {
        extraFieldsContainer.innerHTML = '';  // Effacer les anciens inputs

        switch (this.value) {
            case 'femme':
                extraFieldsContainer.innerHTML = `

                    <div>
                        <label for="technique">Choisissez la technique :</label>
                        <select id="technique" name="technique" required>
                            <option value="">-- Choisir --</option>
                            <option value="none">-- Aucune --</option>
                            <option value="Coloration">Coloration</option>
                            <option value="Balayage/mèche">Balayage/mèche</option>
                        </select>
                    </div>

                    <div>
                        <label for="coupe">Une coupe :</label>
                        <select id="coupe" name="coupe" required>
                            <option value="">-- Choisir --</option>
                            <option value="Coupe">Oui</option>
                            <option value="none">Non</option>
                        </select>
                    </div>

                    <div>
                        <label for="coiffage">Coiffage :</label>
                        <select id="coiffage" name="coiffage" required>
                            <option value="">-- Choisir --</option>
                            <option value="Brushing">Brushing</option>
                            <option value="Séchage naturel">Séchage naturel</option>
                        </select>
                    </div>
                    <div>
                        <label for="longueur">Choisir une longueur :</label>
                        <select id="longueur" name="longueur" required>
                            <option value="">-- Choisir --</option>
                            <option value="court">Court</option>
                            <option value="milongs">Mi-longs</option>
                            <option value="longs">Longs</option>
                        </select>
                    </div>



                `;
                break;
            
            case 'homme':
                extraFieldsContainer.innerHTML = `
                <div>
                        <label for="prestation">Choisir une prestation :</label>
                        <select id="coupe" name="coupe" required>
                        <option value="">-- Choisir --</option>
                            <option value="Coupe">Coupe</option>
                        </select>
                </div>
                    
                    

                   

                    


                `;
                break;

            
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const steps = document.querySelectorAll('.step');
    let currentStep = 0;

    function showStep(index) {
        steps.forEach((step, i) => {
            step.style.display = i === index ? 'block' : 'none';
        });
        currentStep = index;
    }

    function validateStep(stepIndex) {
        const inputs = steps[stepIndex].querySelectorAll('select, input');
        for (const input of inputs) {
            console.log(input.name, input.value, input.checkValidity());
            if (!input.checkValidity()) {
                input.reportValidity();
                return false;
            }
        }
        return true;
    }

    document.getElementById('next1').addEventListener('click', () => {
        if (validateStep(0)) {
            showStep(1);
            console.log('Step 1 validée, on passe à Step 2');
        } else {
            console.log('Step 1 non valide');
        }
    });

    document.getElementById('prev2').addEventListener('click', () => {
        showStep(0);
        console.log('Retour à Step 1');
    });

    document.getElementById('next2').addEventListener('click', () => {
        if (validateStep(1)) {
            showStep(2);
            console.log('Step 2 validée, on passe à Step 3');
        } else {
            console.log('Step 2 non valide');
        }
    });

    document.getElementById('prev3').addEventListener('click', () => {
        showStep(1);
        console.log('Retour à Step 2');
    });

    showStep(0);
});
document.addEventListener('DOMContentLoaded', function () {
    const addClientBtn = document.getElementById('addClientBtn');
    addClientBtn.addEventListener('click', function () {
        window.location.href = 'addClient';
    });
});
