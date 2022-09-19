<?php
if (!defined('_INCODE')) die('Access Deined....');

$data = [
    'pageTile' => 'ユーザー　運営　ホームページ'
];

layout('header', $data);

// search and purify

$filter = '';
if (IsGet()) {
    $body = getBody();

    // purify
    if (!empty($body['status'])) {
        $status = $body['status'];

        if ($status == 2) {
            $sqlStatus = 0;
        } else {
            $sqlStatus = $status;
        }
        if (!empty($filter) && strpos($filter, 'WHERE') >= 0) {
            $operator = 'AND';
        } else {
            $operator = 'WHERE';
        }
        $filter .= " WHERE status='$sqlStatus'";
    }

    // sreach 
    if (!empty($body['keyword'])) {
        $keyword = $body['keyword'];

        if (!empty($filter) && strpos($filter, 'WHERE') >= 0) {
            $operator = 'AND';
        } else {
            $operator = 'WHERE';
        }

        $filter .= "$operator fullname LIKE '%$keyword%'";
    }
}




// pagination 
$AllUser = getRows("SELECT id FROM user $filter");
$Perpage = 4;
$maxPage = ceil($AllUser / $Perpage);


if (!empty(getBody()['page'])) {
    $page = getBody()['page'];
    if ($page < 1 || $page > $maxPage) {
        $page = 1;
    }
} else {
    $page = 1;
}

$offset = ($page - 1) * $Perpage;

$listAllUser = getRaw("SELECT * FROM user $filter ORDER BY createAt DESC LIMIT $offset,$Perpage");

// sreach and pagination

$quyeryString = null;
if (!empty($_SERVER['QUERY_STRING'])) {

    $quyeryString = $_SERVER['QUERY_STRING'];

    $quyeryString = str_replace('module=user', '', $quyeryString);
    $quyeryString = str_replace('&page=' . $page, '', $quyeryString);
    $quyeryString = trim($quyeryString, '&');
    $quyeryString = '&' . $quyeryString;
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg-type');

?>
<div class="container">
    <hr />
    <h3 class="text-center"><?php echo (!empty($data['pageTile'])) ? $data['pageTile'] : ''; ?></h3>
    <p>
        <a href="?module=user&action=add" class="btn btn-success"> ユーザー 追加 </a>
    </p>
    <form action="" method="get">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <select name="status" class="form-control">
                        <option value="0">状態 選択</option>
                        <option value="1" <?php echo (!empty($status) && $status == 1) ? 'selected' : false; ?>>Online
                        </option>
                        <option value="2" <?php echo (!empty($status) && $status == 2) ? 'selected' : false; ?>>Offline
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-6">
                <input type="search" class="form-control" name="keyword" placeholder="キーワード検索"
                    value="<?php echo (!empty($keyword)) ? $keyword : false; ?>" />
            </div>
            <div class="col-3">
                <button type="submit" class="btn btn-primary ">検索</button>
            </div>
        </div>
        <?php echo getMsg($msg, $msgType); ?>
        <input type="hidden" name="module" value="user">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">番目</th>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>電話番号</th>
                    <th>状態</th>
                    <th width="5%">直す</th>
                    <th width="5%">消し</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($listAllUser)) :
                    $count = 0;
                    foreach ($listAllUser as  $iteam) :
                        $count++;
                ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $iteam['fullname']; ?></td>
                    <td><?php echo $iteam['email']; ?></td>
                    <td><?php echo $iteam['phone']; ?></td>
                    <td><?php echo (!empty($iteam['status']) != 1) ? '<a class="btn btn-warning btn-sm">Offline</a>' : '<a class="btn btn-success btn-sm">Online</a>'; ?>
                    </td>
                    <td><a href="<?php echo _WEB_HOST_ROOT . '?module=user&action=edit&id=' . $iteam['id']; ?>"
                            class="btn btn-warning btn-sm">直</a></td>
                    <td><a href="<?php echo _WEB_HOST_ROOT . '?module=user&action=delete&id=' . $iteam['id']; ?>"
                            onclick="return confirm('消しますか?')" class="btn btn-danger btn-sm">消</a>
                    </td>
                </tr>
                <?php endforeach;
                else : ?>
                <tr>
                    <td colspan="7">
                        <div class="alert alert-danger text-center">No user</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($page > 1) {
                    $prevPage = $page - 1;
                    echo '<li class="page-item"><a class="page-link" href="' . _WEB_HOST_ROOT . '?module=user' . $quyeryString . '&page=' . $prevPage . '">Previous</a></li>';
                } ?>

                <?php

                $begin = $page - 2;
                $end = $page + 2;

                ($begin < 1) ? $begin = 1 : false;
                ($end > $maxPage) ? $end = $maxPage : false;

                for ($index = $begin; $index <= $end; $index++) {  ?>
                <li class="page-item"><a class="page-link"
                        href="<?php echo _WEB_HOST_ROOT . '?module=user' . $quyeryString . '&page=' . $index; ?>"><?php echo $index; ?></a>
                </li>
                <?php }
                if ($page < $maxPage) {
                    $nextPage = $page + 1;
                    echo ' <li class="page-item"><a class="page-link" href="' . _WEB_HOST_ROOT . '?module=user' . $quyeryString . '&page=' . $nextPage . '">Next</a></li>';
                }
                ?>

            </ul>
        </nav>
    </form>

</div>
<?php

layout('footer');