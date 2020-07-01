<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$script = <<< JS
    $('.rubric-btn').click((e) => clickRubric(e));

    renderNews('news?page=1')
    
    function clickRubric(e) {
        e.preventDefault();
        $('#table-news').html('');
        $('#table-pagination').html('');
        $.ajax({
            url: e.currentTarget.href,
            type: 'GET',
            success: function(data) {
                return renderNews('/rubric/' + data.id + '/news?page=1');
            }
        });
    }
    
    function renderNews(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data, textStatus, request) {
                if(data.length === 0)
                {
                    return $('#table-news').append('<p class="text-danger">Данных нет</p>');
                }
                else
                {
                    $('#table-news').append(renderTh(data[0]) + '<tbody>');
                    $('#table-pagination').append(renderPagination(request, this.url));
                    const pageButtons = $('.page-btn');
                    if(pageButtons[0] !== 'undefined') {
                        pageButtons.click((e) => clickPage(e));
                    }         
                    data.map((item) => {
                        $('#table-news').append(renderTd(item));
                    })
                }
            }
        });
    }
    
    function clickPage(e) {
        e.preventDefault();
        $('#table-news').html('');
        $('#table-pagination').html('');
        return renderNews(e.currentTarget.href);
    }
    
    function renderTh(item) {
        arr = Object.keys(item);
        result = '';
        arr.map((el) => result += '<th>' + el + '</th>')
        return '<thead> <tr>' + result + '</tr> </thead>';
    }
    
    function renderTd(item) {
        arr = Object.values(item);
        result = ''
        arr.map((el) => result += '<td>' + el + '</td>')
        return '<tr>' + result + '</tr>';
    }
    
    function renderPagination(item, url) {
        const total = parseInt(item.getResponseHeader('X-Pagination-Total-Count'));
        const pageCount = parseInt(item.getResponseHeader('X-Pagination-Page-Count'));
        const currPage = parseInt(item.getResponseHeader('X-Pagination-Current-Page'));
        const perPage = parseInt(item.getResponseHeader('X-Pagination-Per-Page'));
        result = '';
        if(pageCount > 1){
            
            url = url.substring(0, url.indexOf('page='));
            
            for (let i = 1; i <= pageCount; i++){
                if(i === currPage) {
                    result += '<li class="active"><a class="page-btn" href="' + url + 'page=' + i + '">' + i + '</a></li>'
                }
                else
                {
                    result += '<li><a class="page-btn" href="' + url + 'page=' + i + '">' + i + '</a></li>';
                }
            }
        }
        
        return result;
    }
JS;
$this->registerJs($script);
?>
<div class="site-index">
    <?php
        foreach ($rubric as $r)
            echo '<a class="btn btn-primary rubric-btn" href="/rubric/'. $r['id'] . '">' . $r['title'] . '</a>';
    ?>
    <table id="table-news" class="table table-bordered" style="margin-top:2rem">
    </table>
    <ul id='table-pagination' class="pagination">
    </ul>
</div>
