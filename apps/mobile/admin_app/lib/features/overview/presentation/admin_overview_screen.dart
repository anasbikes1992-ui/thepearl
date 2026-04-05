import 'package:flutter/material.dart';

class AdminOverviewScreen extends StatelessWidget {
  const AdminOverviewScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('PearlHub Admin')),
      body: ListView(
        padding: const EdgeInsets.all(16),
        children: const <Widget>[
          Card(child: ListTile(title: Text('KYC Queue'), subtitle: Text('Pending provider/customer verifications'))),
          Card(child: ListTile(title: Text('Disputes'), subtitle: Text('Escrow dispute mediation queue'))),
          Card(child: ListTile(title: Text('Business Analytics'), subtitle: Text('GMV, churn, LTV, retention'))),
        ],
      ),
    );
  }
}
