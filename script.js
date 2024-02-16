var searchInput = document.querySelector('.board-search-input');

        searchInput.addEventListener('input', function() {
            var searchTerm = searchInput.value.toLowerCase();

            var lists = document.querySelectorAll('.list');
            for (var i = 0; i < lists.length; i++) {
                var listTitle = lists[i].querySelector('.list-title').innerText.toLowerCase();
                if (listTitle.includes(searchTerm)) {
                    lists[i].style.display = 'block';
                } else {
                    lists[i].style.display = 'none';
                }
            }
        });