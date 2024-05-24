const errorMesgEl = document.querySelector('.error_message');
const budgetInputEl = document.querySelector('.budget_input');
const expensesDescEl = document.querySelector('.expenses_input');
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

    btnBudgetCal.addEventListener('click', (e) => {
        e.preventDefault();
        budgetFun();
    });

    btnExpensesCal.addEventListener('click', (e) => {
        e.preventDefault();
        expensesFun();
    });
}

document.addEventListener("DOMContentLoaded", btnEvents);

function expensesFun() {
    let expensesDescValue = expensesDescEl.value;
    let expensesAmountValue = expensesAmountEl.value;

    if (expensesDescValue === "" || expensesAmountValue === "" || expensesAmountValue < 0) {
        alert("Please Enter Expenses Name or Amount");
    } else {
        let amount = parseInt(expensesAmountValue);
        expensesAmountEl.value = "";
        expensesDescEl.value = "";

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
    const html = `
        <ul class="tbl_tr_content" data-id="${expensesPara.id}">
            <li>${expensesPara.id}</li>
            <li>${expensesPara.title}</li>
            <li>₱ <span>${expensesPara.amount}</span></li>
            <li>
                <button type="button" class="btnEdit">Edit</button>
                <button type="button" class="btnDel">Delete</button>
            </li>
        </ul>
    `;

    tblRecordsEl.insertAdjacentHTML('beforeend', html);

    document.querySelectorAll('.btnEdit').forEach(btn => {
        btn.addEventListener('click', (e) => {
            editExpenses(e);
        });
    });

    document.querySelectorAll('.btnDel').forEach(btn => {
        btn.addEventListener('click', (e) => {
            deleteExpenses(e);
        });
    });
}

function editExpenses(event) {
    let element = event.target.closest('.tbl_tr_content');
    let id = element.dataset.id;

    let expense = itemList.find(item => item.id == id);

    if (expense) {
        expensesDescEl.value = expense.title;
        expensesAmountEl.value = expense.amount;

        const btnSaveEdit = document.createElement('button');
        btnSaveEdit.textContent = 'Save Edit';
        btnSaveEdit.classList.add('btnSaveEdit');
        document.querySelector('.ur_expenses').appendChild(btnSaveEdit);

        btnSaveEdit.addEventListener('click', (e) => {
            e.preventDefault();
            expense.title = expensesDescEl.value;
            expense.amount = parseInt(expensesAmountEl.value);

            element.querySelector('li:nth-child(2)').textContent = expense.title;
            element.querySelector('li:nth-child(3) span').textContent = expense.amount;

            expensesDescEl.value = '';
            expensesAmountEl.value = '';
            btnSaveEdit.remove();

            showBalance();
        });
    }
}

function deleteExpenses(event) {
    let element = event.target.closest('.tbl_tr_content');
    let id = element.dataset.id;

    itemList = itemList.filter(item => item.id != id);
    element.remove();

    showBalance();
}

function budgetFun() {
    const budgetValue = budgetInputEl.value;

    if (budgetValue === "" || budgetValue < 0) {
        alert("Please enter your budget value");
    } else {
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

    if (itemList.length > 0) {
        total = itemList.reduce((acc, curr) => {
            acc += curr.amount;
            return acc;
        }, 0);
    }
    expensesCardEl.textContent = total;
    return total;
}

function errorMessage(message) {
    errorMesgEl.innerHTML = `<p>${message}</p>`;
    errorMesgEl.classList.add("error");
    setTimeout(() => {
        errorMesgEl.classList.remove("error");
    }, 2500);
}
