// script.js
const profileBtn = document.getElementById('profile-btn');
const dropdown = document.getElementById('profile-dropdown');

profileBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    dropdown.classList.toggle('hidden');
});

document.addEventListener('click', () => {
    dropdown.classList.add('hidden');
});
