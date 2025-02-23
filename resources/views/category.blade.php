<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
    <li><a class="dropdown-item" href="#" style="padding: 0; pointer-events: none;">Chó </a>
        <ul class="sub-menu" id="dog">
            {{-- menu chó --}}
        </ul>
    </li>
    <li><a class="dropdown-item" href="#" style="padding: 0; pointer-events: none;">Mèo</a>
        <ul class="sub-menu" id="meow">
            {{-- menu meow --}}
        </ul>
    </li>
</ul>

<script>
    function fetchCategory(url, containerId) {
        var container = document.getElementById(containerId);
        container.innerHTML = '';        
        $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    data.cate.forEach(function(cate) {
                        var li = document.createElement('li');
                        var a = document.createElement('a');
                        a.href = "{{ URL::to('/san-pham') }}-"+ container.id + "-" +cate.id;
                        a.textContent = cate.name; 
                        li.appendChild(a);
                        container.appendChild(li);
                    });
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
    }
    //Gọi hàm lấy danh mục cho chó và meow
    fetchCategory('api/category', 'dog');
    fetchCategory('api/category', 'meow');

</script>