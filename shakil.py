from graphviz import Digraph

def generate_prime_flowchart():
    dot = Digraph()
    
    # Start
    dot.node('Start', 'Start', shape='oval')
    dot.node('Input', 'Input: Integer from User', shape='parallelogram')
    
    # Loop condition
    dot.node('Loop', 'For i = 2 to sqrt(N)', shape='diamond')
    dot.node('Check', 'Is N % i == 0?', shape='diamond')
    dot.node('Not Prime', 'NOT PRIME\nEnd', shape='oval')
    dot.node('Next', 'Next i', shape='rectangle')
    dot.node('Prime', 'PRIME\nEnd', shape='oval')
    
    # Edges
    dot.edge('Start', 'Input')
    dot.edge('Input', 'Loop')
    dot.edge('Loop', 'Check', label='i <= sqrt(N)')
    dot.edge('Check', 'Not Prime', label='Yes')
    dot.edge('Check', 'Next', label='No')
    dot.edge('Next', 'Loop')
    dot.edge('Loop', 'Prime', label='No divisors found')
    
    # Render Flowchart
    dot.render('prime_number_flowchart', format='png', cleanup=False)
    
    print("Flowchart saved as prime_number_flowchart.png")

# Generate flowchart
generate_prime_flowchart()

