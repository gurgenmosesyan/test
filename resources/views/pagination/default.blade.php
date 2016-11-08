<?php
$link_limit = $isMobile ? 8 : 10;
if ($model->lastPage() > 1) {
?>
    <div id="paging">
        <ul>
            <li class="arrow prev fl{{$model->currentPage() == 1 ? ' disabled' : ''}}">
                <a class="db" href="{{$model->url($model->currentPage() - 1)}}"><</a>
            </li>
            <?php
            for ($i = 1; $i <= $model->lastPage(); $i++) {
                $half_total_links = floor($link_limit / 2);
                $from = $model->currentPage() - $half_total_links;
                $to = $model->currentPage() + $half_total_links;
                if ($model->currentPage() < $half_total_links) {
                    $to += $half_total_links - $model->currentPage();
                }
                if ($model->lastPage() - $model->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($model->lastPage() - $model->currentPage()) - 1;
                }
                if ($from < $i && $i < $to) {
                ?>
                    <li class="fl">
                        <a class="db {{$model->currentPage() == $i ? ' active' : ''}}" href="{{$model->url($i)}}">{{$i}}</a>
                    </li>
            <?php
                }
            }
            ?>
            <li class="arrow next fl{{$model->currentPage() == $model->lastPage() ? ' disabled' : ''}}">
                <a class="db" href="{{$model->url($model->currentPage() + 1)}}">></a>
            </li>
            <li class="cb"></li>
        </ul>
    </div>
<?php } ?>