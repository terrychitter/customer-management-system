class Customer:
    def __init__(self, acc_num, bbf_amount, fee_amount, less_credit, adjustments, bbf_date,
                fee_date, invoice_issue_date, name, address, suburb, postal, invoice_num, reference):
        self.acc_num = acc_num
        self.bbf_amount = bbf_amount
        self.fee_amount = fee_amount
        self.less_credit = less_credit
        self.adjustments = adjustments
        self.bbf_date = bbf_date
        self.fee_date = fee_date
        self.invoice_issue_date = invoice_issue_date
        self.name = name
        self.address = address
        self.suburb = suburb
        self.postal = postal
        self.invoice_num = invoice_num
        self.reference = reference
