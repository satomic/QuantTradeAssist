import sqlite3 as sq

class Coin_DB:
	def __init__(self, db_name):
		self.db = sq.connect(db_name)
	
	def create_table(self, talbe):
		self.db.execute(talbe)
		

	def insert_to_table(self, insert_list):
		
		for insert_op in insert_list:
			self.db.execute(insert_op)
		
		self.db.commit()

	def selcet_from_table(self, select_list):
		result_list = []

		for select_op in select_list:
			cursor = self.db.execute(select_op)
			result_list.append(cursor)

		return result_list

	def close_db(self):
		self.db.close()

#Test for Coin_DB
# coin = Coin_DB("coin1")

# table = '''CREATE TABLE COMPANY
#        (ID INT PRIMARY KEY     NOT NULL,
#        NAME           TEXT    NOT NULL,
#        AGE            INT     NOT NULL,
#        ADDRESS        CHAR(50),
#        SALARY         REAL);'''

# # coin.create_table(table)

# # insert_list = ["INSERT INTO COMPANY (ID,NAME,AGE,ADDRESS,SALARY) VALUES (3, 'Paul', 32, 'California', 20000.00 )"]

# # coin.insert_to_table(insert_list)

# select_list = ["SELECT id, name, address, salary  from COMPANY"]

# result_list = coin.selcet_from_table(select_list)

# coin.close_db()