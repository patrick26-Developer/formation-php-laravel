# Solution — Exercise 2

- **Author → Book: 1-N**. An author can have written several books (assuming a single main author per book), but each book has a single main author.

- **Book ↔ Member (via Loan): N-N**. A book can be borrowed by several different members over time (at different times), and a member can borrow several books. That's why an intermediate `Loan` entity is needed — it also carries its own attributes (dates), which a simple pivot table couldn't do as naturally.

- **Member → LibraryCard: 1-1**. Each member has exactly one card, and each card belongs to a single member.
