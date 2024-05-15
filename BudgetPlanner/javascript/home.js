const errorMesgEl = document.querySelector('.error_message');
const budgetInputEl = document.querySelector('.budget_input');
const expensesDelEl = document.querySelector('.expenses_input');
const expensesAmountEl = document.querySelector('.expenses_amount');
const tblRecordsEl = document.querySelector('.tbl_data');
const cardsContainerEl = document.querySelector('.cards');

const budgetCardEl = document.querySelector('.budget_card');
const expensesCardEl = document.querySelector('.expenses_card');
const balancesCardEl = document.querySelector('.balance_card');

let itemList = [];
let itemId = 0;

function btnEvents() {
    const btnBudgetCal = document.querySelector('#btn_budget');
    const btnExpensesCal = document.querySelector('#btn_expenses');

    btnBudgetCal.addEventListener('click',(e) => {
        e.preventDefault();
        budgetFun();
    })

    btnExpensesCal.addEventListener('click',(e) => {
        e.preventDefault();
        expensesFun();
    })
}

document.addEventListener("DOMContentLoaded", btnEvents);

function expensesFun() {
    let expensesDescValue = expensesDelEl.value;
    let expensesAmountValue = expensesAmountEl.value;

    if(expensesDescValue == ""  || 
        expensesAmountValue == "" || 
        budgetInputEl < 0) {
        alert("Please Enter Expenses Name or Amount");

    } else {
        let amount = parseInt(expensesAmountValue);
        expensesAmountEl.value = "";
        expensesDelEl.value = "";

        let expenses = {
            id: itemId,
            title: expensesDescValue,
            amount: amount
        };

        itemId++;
        itemList.push(expenses);

        addExpenses(expenses);
        showBalance();
    }
}

function addExpenses(expensesPara) {
    const html = `<ul class="tbl_tr_content">
    <li data-id=${expensesPara.id}>${expensesPara.id}</li>
    <li>${expensesPara.title}</li>
    <li>₱ <span>${expensesPara.amount}</span></li>
    <li>
        <button type="button" class="btn_edit"> Edit
        </button>
        <button type="button" class="btn_delete"> Delete
        </button>
    </li>
</ul>`;

tblRecordsEl.insertAdjacentHTML('beforeend', html);

const btnEdit = document.querySelectorAll('btn_edit');
const btnDel = document.querySelectorAll('btn_delete');
const contentId = document.querySelectorAll('.tbl_tr_content');

btnEdit.forEach((btnEdit) => {
    btnEdit.addEventListener('click', (el) => {
        let id;
        contentId.forEach((ids) => {
            id = ids.firstElementChild.dataset.id;
        });
        let element = el.target.parentElement.parentElement;
        element.remove();

        let expenses = itemList.filter(function (item) {
            return item.id == id;
        });

        expensesDelEl.value = expenses[0].title;
        expensesAmountEl.value = expenses[0].amount;

        let temp_list = itemList.filter(function (item) {
            return item.id !== id;
        });

        itemList = temp_list;
    });
});

btnDel.forEach((btnDel) => {
    btnDel.addEventListener('click', (el) => {
        let id;
        contentId.forEach((ids) => {
            id = ids.firstElementChild.dataset.id;
        });
        let element = el.target.parentElement.parentElement;
        element.remove();

        let temp_list = itemList.filter(function (item) {
            return item.id !== id;
        });
        
        itemList = temp_list;
        showBalance();
    });
});

}


function budgetFun() {

    const budgetValue = budgetInputEl.value;

    if (budgetValue == "" || budgetValue < 0){
        alert("Please enter your budget value");
    }else {
        budgetCardEl.textContent = budgetValue;
        budgetInputEl.value = "";
        showBalance();
    }
}

function showBalance() {
    const expenses = totalExpenses();
    const total = parseInt(budgetCardEl.textContent) - expenses;
    balancesCardEl.textContent = total;
}

function totalExpenses() {
    let total = 0;

    if(itemList.length > 0) {
        total = itemList.reduce(function(acc, curr){
            acc += curr.amount;
            return acc;

        }, 0)
    }
    expensesCardEl.textContent = total;
    return total;
}

    function errorMessage(message){
        alert = `<p>${message}</p>`;
        errorMesgEl.classList.add("error");
        setTimeout(() => {
            errorMesgEl.classList.remove("error");
        }, 2500);
    }
