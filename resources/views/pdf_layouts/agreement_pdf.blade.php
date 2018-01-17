<html>
<head>
	<style>  
		p {  
			padding-top: 5px;  
			padding-bottom: 5px;  
			padding-right: 5px;  
			padding-left: 30px;
		}  
		div  {  
			padding-top: 5px;  
			padding-bottom: 5px;  
			padding-right: 5px;  
			padding-left: 30px;  
		}

	</style> 
	<title>Contract Agreement</title>

</head>
<body>
	<div style="text-align:center">
		<p align="center"><strong>{{ strtoupper($contract[0]->companyName) }}</strong>
			<br/>
			(On a Per Trip Basis)
			<br/>
		</p>
	</div>
	<div style="text-align:justify-all">
		KNOW ALL MEN BY THESE PRESENTS:
		<br/>
		<br/>
		This contract made and executed this <span style="border-bottom: 1px solid black;">{{ Carbon\Carbon::parse($contract[0]->created_at)->format('jS \\of F Y') }} </span>by and 
		between:
		<br/>
		<br/>

		<strong>{{ strtoupper($contract[0]->companyName) }}</strong>, a domestic corporation duly
		organized and existing under and by the virtue of the laws of the Republic of the
		Phillipines, with office address at {{ $contract[0]->address }}
		represented by its General Manager, <strong>{{ $contract[0]->name }}</strong>, hereinafter referred to as the <strong>FIRST PARTY</strong>.<br/>
		<p align="center">
			<strong> -and-</strong>
		</p>
		<strong>HAULING SERVICE COMPANY</strong>, likewise a domestic corporation duly
		organized and existing under and by virtue of the Republic of the Phillipines, with
		office address at 318 Velco Centre cor Oca and Delgado Sts. South Harbor, Manila
		represented by its President, <strong>JOSELITO A. CASTILLO</strong>, hereinafter referred to as 
		the <strong>SECOND PARTY</strong>.

		<p align="center">
			<strong>-WITNESSETH-</strong>
		</p>

		<strong>WHEREAS</strong>, the <strong>FIRST PARTY</strong> needs the services of a contractor to handle a portion of the delivery and / or pick-up of various products and cargoes to and from its customers.
		<br/>
		<br/>

		<strong>WHEREAS</strong>, the <strong>SECOND PARTY</strong> is a duly licensed entity authorized to undertake hauling services on behalf of other entities sucha as the <strong>FIRST PARTY</strong> and has sufficient manpower, capital and equipment to perform the job.
		<br/>
		<br/>

		<strong>NOW THEREFORE</strong>, for and in consideration of the foregoing premises, the parties have hereunto agreed as follows:
		
		@if($contract[0]->specificDetails == null)
		<h5 style="text-align: center;">No specified details</h5>
		@else
		<p>{!! $contract[0]->specificDetails !!}</p>
		@endif
		<div style="page-break-before: always;">
			<strong>IN WITNESS WHEREOF</strong>, the parties hereunto have signed this contract on this ____________ day of ________________, 2016 at __________________________________ Philippines.
			<br/>
			<br />
			<br/>
			<br />
			<br/>
			<br />
			<table style="width: 100%;">
				<tr>
					<td style="width: 35%; text-align: center;">
						<hr />
						<strong>{{ $contract[0]->name }}</strong>
						<br />
						{{ $contract[0]->companyName }}
					</td>
					<td style="width: 30%;">

					</td>
					<td style="width: 35%; text-align: center;">
						<hr />
						<strong>Mr. President</strong>
						<br />
						Hauling Service Company
					</td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: center;">
						<br />
						<br />
						<strong>SIGNED IN THE PRESENCE OF</strong>
						<br />
						<br />
						<br />
					</td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td style="width: 35%; text-align: center;">
						<hr />
					</td>
					<td style="width: 30%;">

					</td>
					<td style="width: 35%; text-align: center;">
						<hr />
					</td>
				</tr>
			</table>


			<p align="center"><strong>ACKNOWLEDGEMENT</strong></p>

			<p><strong>REPUBLIC OF THE PHILIPPINES 		)</strong></p>
			<p><strong>CITY OF TAGUIG		)S.S</strong></p>
			<p>		<strong>BEFORE ME,</strong> a Notary Public in _______________________________, this _______ day of _________________ 2016, personally appeared the following with their respective Community Tax Certificate No./ Passport No. as herein below indicate:</p>

			<table align="center" style="width: 100%;" >
				<thead>
					<tr>
						<td style="width: 10%;"></td>
						<td style="width: 70%;"><strong><u>Name</u></strong></td>
						<td style="width: 20%;"></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="width: 10%;"></td>
						<td style="width: 70%;"><strong>{{ strtoupper($contract[0]->name) }}</strong></td>
						<td style="width: 20%;"></td>
					</tr>
					<tr>
						<td style="width: 10%;"></td>
						<td style="width: 70%;"><strong>JOSELITO A. CASTILLO</strong></td>
						<td style="width: 20%;"></td>
					</tr>
				</tbody>
			</table>

			<br />

			<p>
				<strong>KNOWN TO ME</strong> to be the same person who executed the foregoing instrument and they acknowledge that the same of their own free and voluntary act and deed as well as that of the entities they respectively represent.
			</p>
			<p>
				<strong>WITNESSED MY HAND AND SEAL,</strong> at the place and on the dates first above written.
			</p>

			Doc No. ___________<br/>
			Page No. ___________<br/>
			Book No. ___________<br/>
			Series of 2016.
		</div>
	</div>
</body>
</html>