<?php
// Form chung dùng để nhập a, b, n và chọn action
// File: BTVN/common/form.php
?>
<div class="form-common">
    <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label for="action">Chọn hành động:</label>
        <select id="action" name="action">
            <option value="">-- chọn --</option>
            <option value="prime"<?php echo (isset($_GET['action']) && $_GET['action']==='prime') ? ' selected' : ''; ?>>Kiểm tra số nguyên tố</option>
            <option value="fact"<?php echo (isset($_GET['action']) && $_GET['action']==='fact') ? ' selected' : ''; ?>>Tính giai thừa</option>
            <option value="gcd"<?php echo (isset($_GET['action']) && $_GET['action']==='gcd') ? ' selected' : ''; ?>>Tìm ƯCLN</option>
            <option value="maxmin"<?php echo (isset($_GET['action']) && $_GET['action']==='maxmin') ? ' selected' : ''; ?>>Tìm max/min</option>
        </select>
        <div>
            <label for="n">n:</label>
            <input type="text" id="n" name="n" value="<?php echo isset($_GET['n']) ? htmlspecialchars($_GET['n'], ENT_QUOTES, 'UTF-8') : ''; ?>" />
        </div>
        <div>
            <label for="a">a:</label>
            <input type="text" id="a" name="a" value="<?php echo isset($_GET['a']) ? htmlspecialchars($_GET['a'], ENT_QUOTES, 'UTF-8') : ''; ?>" />
            <label for="b"> b:</label>
            <input type="text" id="b" name="b" value="<?php echo isset($_GET['b']) ? htmlspecialchars($_GET['b'], ENT_QUOTES, 'UTF-8') : ''; ?>" />
        </div>
        <button type="submit">Gửi</button>
    </form>
</div>


