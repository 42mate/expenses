# Expenses

Expenses is a web application to track expenses and incomes in order to 
get insights on where you money is going.

Features

- Track Expenses
- Track Incomes
- Wallets
- Multiple currency, even crypto
- Track Loans (TBD)
- Transfers between wallets (TBD)
- Multiple reports

## Concepts

### Expenses

An Expense is a transaction where you spend money. For example when you buy groceries.

### Income

An Income is a transaction where you gain money. For example you get paid for a service, or you receive your salary.

### Expenses categories

Categories are used to classify the expenses in order to get better reporting on the expenses.

### Income Sources

Are the sources of income, as expense categories, this is used to get betters reporting on where the money is coming.

### Loans

Loans is when you gave money to somebody or you ask to somebody for money. Expenses will help you to do not forget the money given or asked.

### Recurrent Expenses

These are expenses that happen regularly on a given period of time. For example the power bill, the water service, the telephone bill, the credit card expenses, the mortgage, etc.

You can create all your recurrent expenses list so, it will make easy to record the payment of the expense and Expenses will make you remember on `pending payments` section the expenses that you haven't paid yet.

You won't forget to pay you compromises never again.

### Wallets

A wallet is where you have money, it can be a Bank Account, a Digital Wallet, a crypto wallet, a box in your home with cash, etc.

You can have multiple wallets, as much as you need.

Every wallets has their own balance, how much money it has.

Every wallet has a given currency.

When you create an expense selecting a wallet, the balance is updated subtracting the amount of the expense from the wallet balance. The opposite happens if is an income, the amount is added to the wallet. This is how the system keeps the wallet balance updated.

### Currencies

These are common currencies for money, for example US Dollars, Yen, Mexican Pesos or even Currencies from the crypto world such as Bitcoin, Dai, USDC, USDT, etc.

As we said, every wallet as a currency.

Expenses supports multiple currencies. 

Expenses also have a default currency, the one that is selected by default.

Every wallet has a related currency, when a transaction is made in the wallet, the transaction will be using the wallet currency.

If no wallet is involved in the transaction, the default currency will be used.

## Guides Index

[[Onboarding]]
[[Default currency]]
[[Category]]
[[Expense]]
[[Wallets]]
[[Income source]]
[[Income]]
[[Recurrent Expenses]]
[[Loans]]