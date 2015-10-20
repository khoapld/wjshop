<div class="row">
    <div class="col-md-12 header-btns">
        <button class="btn btn-primary pull-right" id="create-expense" >Create expense</button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12" id="create-expense-form"></div>
</div>
<br>
<div class="jumbotron" id="expense-list">
    <?php if (!empty($expenses)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col-md-1">#</th>
                    <th class="col-md-2">Date</th>
                    <th class="col-md-6">Expense Name</th>
                    <th class="col-md-3 text-right">Expense Price (VND)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expenses as $k => $expense): ?>
                    <tr>
                        <th scope="row"><?php echo $k + 1; ?></th>
                        <td><?php echo date('Y-m-d', strtotime($expense->created_at)); ?></td>
                        <td id="name<?php echo $k + 1; ?>"><?php echo $expense->expense_name; ?></td>
                        <td id="price<?php echo $k + 1; ?>" class="text-right"><?php echo number_format($expense->expense_price); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-right">Total: </td>
                    <td class="text-right"><?php echo number_format($expense_total); ?></td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p>You don't have any expense in <?php echo date('F'); ?>.</p>
    <?php endif; ?>
</div>