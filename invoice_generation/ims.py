
##################################MAIN#########################################
import os
import csv
import pandas as pd
from pathlib import Path #for previous-directory finding
from menu import Menu
from invoice_manager import InvoiceManager


#Getting invoice and template files
os.system('') #So that colours may work in the command prompt
CURRENT_DIR = os.getcwd()
PARENT_DIR = os.path.dirname(CURRENT_DIR)
invoice_template_file_path = CURRENT_DIR + "\\invoice_generation\\data\\invoice_template.xlsx"
invoices_dir = PARENT_DIR + "\\CMS\\Invoices\\"
data_file_path = PARENT_DIR + "\\CMS\\datafiles\\invoice_data.txt"
data_file = open(PARENT_DIR + '\\CMS\\datafiles\\invoice_data.txt', 'r')

#Converting file to csv
data_file_csv = pd.read_csv (PARENT_DIR + '\\CMS\\datafiles\\invoice_data.txt')
data_file_csv.to_csv (PARENT_DIR + '\\CMS\\datafiles\\invoice_data.csv', index=None)
print(data_file_path)

#Intialising the invoice InvoiceManager
invoice_manager = InvoiceManager(data_file_path, invoice_template_file_path, invoices_dir)
invoice_manager.set_up_workbooks()

#Getting year and month
#invoice_manager.set_year_path(invoice_manager.set_invoice_path('YEAR'))
#invoice_manager.set_month_path(invoice_manager.set_invoice_path('MONTH'))

#Getting date
with open(PARENT_DIR + '\\CMS\\datafiles\\invoice_data.csv', 'r') as csv_file:
    csv_reader = csv.reader(csv_file)

    # Getting the year and month
    for line in csv_reader:
        month = line[0]
        year = line[1]
        break

    #Setting the year and month path
    invoice_manager.set_year_path(year)
    invoice_manager.set_month_path(month)

    for line in csv_reader:

        #Getting list of invoices based on user response in the menue
        temp_customer_list = invoice_manager.populate_customer_list(line[0],
                                                    line[1],
                                                    line[2],
                                                    0,
                                                    0,
                                                    line[3],
                                                    line[4],
                                                    line[5],
                                                    line[6],
                                                    line[7],
                                                    line[8],
                                                    line[9],
                                                    line[10],
                                                    line[11])

customer_list = temp_customer_list
invoice_manager.generate_invoices(customer_list)
