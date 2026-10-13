document.addEventListener('DOMContentLoaded', () => {

    const filterButtons = document.querySelectorAll('.btn-filter');
    const recipeCards = document.querySelectorAll('.recipe-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const filterValue = button.getAttribute('data-filter');

            recipeCards.forEach(card => {
                const category = card.getAttribute('data-category');

                if (filterValue === 'todos' || category.includes(filterValue)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    const favoriteButtons = document.querySelectorAll('.btn-favorite');

    favoriteButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            btn.classList.toggle('favorited');
            
            if (btn.classList.contains('favorited')) {
                btn.style.filter = 'drop-shadow(0px 0px 4px red)';
            } else {
                btn.style.filter = 'none';
            }
        });
    });

});
